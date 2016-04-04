<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * LanguageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getLastUsers($nb = 2){
        $query = $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.id', 'DESC')
            ->setMaxResults($nb)
            ->getQuery();

        return $query->getResult();
    }
}