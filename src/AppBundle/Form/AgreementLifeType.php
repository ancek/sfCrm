<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

class AgreementLifeType extends AbstractType
{
    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', null, [
                'label' => 'Wartość umowy'
            ])
            ->add('person', null, [
                'label' => 'Osoba do ubezpieczenia'
            ])
            ->add('client', 'entity', [
                'label' => 'Klient',
                'class' => 'AppBundle\Entity\UserDetailsClient',
                'property' => 'fullName',
                'query_builder' => function(EntityRepository $er) {
                    return $er
                            ->createQueryBuilder('c');
                }
            ])
            ->add('attachments', 'collection', [
                'label' => 'Załącznik',
                'type' => new AttachmentType(),
            ])
        ;
        
        if($this->user->hasRole('ROLE_MANAGER')) {
            $builder
                ->add('agent', 'entity', [
                    'label' => 'Agent',
                    'class' => 'AppBundle\Entity\UserDetailsAgent',
                    'multiple' => false,
                    'expanded' => false,
                    'property' => 'fullName',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->getAgentsQueryBuilder($this->user);
                    }
            ]);
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AgreementLife'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agreementlife';
    }
}
