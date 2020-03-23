<?php


namespace AppBundle\Repository;


use AppBundle\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class SubscriptionRepository extends BaseRepository
{
  public function __construct(EntityManagerInterface $entityManager)
  {
    parent::__construct($entityManager);
  }

  public function getResourceClassName()
  {
    return Subscription::class;
  }

  /**
   * @param string $extensionId
   * @param string $contributorId
   * @return Subscription?
   * @throws NonUniqueResultException
   */
  public function findOne(string $extensionId, string $contributorId)
  {
    return $this->repository->createQueryBuilder('s')
      ->select('s')
      ->leftJoin('s.contributor', 'contributor')
      ->where('s.extension = :extensionId')
      ->andWhere('s.contributor = :contributorId')
      ->setParameter('extensionId', $extensionId)
      ->setParameter('contributorId', $contributorId)
      ->getQuery()
      ->getOneOrNullResult();
  }
}