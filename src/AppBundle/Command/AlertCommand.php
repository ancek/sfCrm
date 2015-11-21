<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Agreement;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Alert;

/**
 * Class AlertCommand
 */
class AlertCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('agreement:check')
            ->setDescription('Send notification')
            ->addArgument(
                'agreement', InputArgument::OPTIONAL, 'Process only choose agreement'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getEntityManager();

        $agreementOptions = $input->getArgument('agreement');

        $output->writeln($agreementOptions);

        if ($agreementOptions === null || in_array($agreementOptions, Agreement::getTypes())) {

            switch ($agreementOptions) {
                case Agreement::AGR_TYPE_LIFE :
                    $repo = 'AppBundle:AgreementLife';

                    break;

                case Agreement::AGR_TYPE_ESTATE :
                    $repo = 'AppBundle:AgreementEstate';

                    break;

                case Agreement::AGR_TYPE_VEHICLE :
                    $repo = 'AppBundle:AgreementVehicle';

                    break;

                default:
                    $repo = 'AppBundle:Agreement';

                    break;
            }

            $date = new \DateTime('now');
            $date->modify('-6 days');
            $date->format('Y-m-d');

            $qb = $em->createQueryBuilder();
            $qb
                ->select('a')
                ->from($repo, 'a')
                ->where('a.createdAt < :date')
                ->setParameter('date', $date);

            $agreements = $qb->getQuery()->getResult();
            $agrCounter = 0;

            // Add alerts to db
            foreach($agreements as $agreement) {
                $alert = new Alert();

                $alert->setTitle(sprintf('Przypomnienie o wygaśnięciu umowy'));
                $alert->setDescription(sprintf('Umowa o numerze %s wygaśnie za 7 dni', $agreement->getNumber()));
                $alert->setIsRead(false);
                $alert->setUser($agreement->getAgent());

                $em->persist($alert);

                $agrCounter++;
            }

            $em->flush();

            // Send email
            $subject = 'Przypomnienie o wygaśnieciu umowy';
            $body = 'Umowa wygasa za 7 dni';

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($this->getContainer()->getParameter('mailer_from'))
                ->setTo($agreement->getAgent()->getUser()->getEmail())
                ->setBody($body)
//                ->setBody(
//                    $this->get('templating')
//                        ->renderResponse('notifications/message.html.twig', [
//                            'username' => $username
//                        ])
            ;

            $output->writeln(sprintf('W %d umowach zbliża się okres wygaśnięcia', $agrCounter));

        } else {
            $output->writeln('Umowa o takim typie nie istnieje');
        }
    }

    private function get($service)
    {
        return $this->getContainer->get($service);
    }

    /**
     * 
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }
}