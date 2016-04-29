<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SerieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SerieRepository extends EntityRepository
{
    public function countNotValidated(){
        $query = $this->createQueryBuilder('serie')
            ->select('COUNT(serie)')
            ->where('serie.validated = false')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getAll(){
        $query = $this->createQueryBuilder('serie')
            ->select('serie')
            ->orderBy('serie.name','ASC')
            ->where('serie.validated= :is_validated' )
            ->setParameter(':is_validated',true)
            ->getQuery();

        return $query->getResult();

    }

    public function getOne($serieId){
        $query = $this->createQueryBuilder('serie')
            ->select('serie')
            ->where('serie.id = :id')
            ->andWhere('serie.validated= :is_validated')
            ->setParameter('id', $serieId)
            ->setParameter(':is_validated',true)
            ->getQuery();

        return $query->getResult();
    }

    public function getOneWithEpisodes($serieId){
        $query = $this->createQueryBuilder('serie')
            ->select('serie')
            ->leftJoin('serie.episodes','episode')
            ->addSelect('episode')
            ->join('serie.language','language')
            ->addSelect('language')
            ->leftJoin('serie.picture','picture')
            ->addSelect('picture')
            ->where('serie.id = :id')
            ->andWhere('serie.validated= :is_validated')
            ->orderBy('episode.saison,episode.episodeNumber')
            ->setParameter('id', $serieId)
            ->setParameter(':is_validated',true)
            ->getQuery();

        return $query->getSingleResult();
    }


    public function getLastSerie($nb = 5,$validated = true){
        $query = $this->createQueryBuilder('serie')
            ->select('serie')
            ->orderBy('serie.id', 'DESC')
            ->andWhere('serie.validated= :is_validated')
            ->setParameter(':is_validated',$validated)
            ->setMaxResults($nb)
            ->getQuery();

        return $query->getResult();
    }

    public function searchLike($like,$limit = 10){
        //TODO : Search in description ?
        $query = $this->createQueryBuilder('serie')
            ->select('serie')
            ->join('serie.picture','picture')
            ->addSelect('picture')
            ->orderBy('serie.name','ASC')
            ->where('serie.validated= :is_validated' )
            ->andWhere('serie.name LIKE :like')
            ->setParameter(':is_validated',true)
            ->setParameter(':like','%'.$like.'%')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }
}
