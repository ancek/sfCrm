<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

/**
 * Description of UserDetailsAgentRepository
 */
class UserDetailsAgentRepository extends EntityRepository
{
    public function getAgentsQueryBuilder(User $user)
    {
        $qb = $this->createQueryBuilder('agent');
        
        if(!$user->hasRole('ROLE_ADMIN')) {
            $qb 
                ->where('agent.manager = :manager')
                ->setParameter('manager', $user);
        }
        
        return $qb;
    }

    public function getAgents(User $user, $queryOnly = false)
    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//        
//        $qb
//            ->select('a')
//            ->from('AppBundle:UserDetailsAgennt', 'a');
        
        $qb = $this->getAgentsQueryBuilder($user);
        
        if($queryOnly) {
            return $qb->getQuery();
        }
        
        return $qb->getQuery()->getResult();
    }
}
