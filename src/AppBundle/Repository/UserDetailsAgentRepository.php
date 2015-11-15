<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

/**
 * Description of UserDetailsAgentRepository
 */
class UserDetailsAgentRepository extends EntityRepository
{
    public function getAgents(User $user)
    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//        
//        $qb
//            ->select('a')
//            ->from('AppBundle:UserDetailsAgennt', 'a');
        
        $qb = $this->createQueryBuilder('agent');
        
        if(!$user->hasRole('ROLE_ADMIN')) {
            $qb 
                ->where('agent.manager = :manager')
                ->setParameter('manager', $user);
        }
        
        return $qb->getQuery()->getResult();
    }
}
