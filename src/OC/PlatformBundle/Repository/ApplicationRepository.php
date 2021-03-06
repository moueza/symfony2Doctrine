<?php

namespace OC\PlatformBundle\Repository;

/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends \Doctrine\ORM\EntityRepository {
/**moi*/
 //   public function getApplicationsWithAdvert(int $limit) {
    public function getApplicationsWithAdvert( $limit) {
//        $qb = $this
//    ->createQueryBuilder('app')
//    ->innerJoin('app.advert', 'adv')
//    ->addSelect('adv')->setMaxResults($limit)->orderBy("app.date", "DESC");
//

                $qb = $this
    ->createQueryBuilder('app')
    ->innerJoin('app.advert', 'adv')
    ->addSelect('adv')->setMaxResults($limit)->orderBy("app.date", "DESC");


  return $qb

    ->getQuery()

    ->getResult()

  ;
    }

}
