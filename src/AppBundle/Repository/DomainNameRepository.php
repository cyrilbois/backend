<?php

namespace AppBundle\Repository;

use AppBundle\Entity\DomainName;
use Doctrine\ORM\EntityManagerInterface;

class DomainNameRepository extends BaseRepository
{
  public function __construct(EntityManagerInterface $entityManager)
  {
    parent::__construct($entityManager);
  }

  public function getResourceClassName()
  {
    return DomainName::class;
  }

  /**
   * @param string $domainName
   * @return DomainName?
   */
  public function findByName(string $domainName) : ?DomainName
  {
    return $this->repository->findOneBy([
      'name' => $domainName
    ]);
  }

  public function findOrCreate(string $domainName) : DomainName
  {
    $existing = $this->findByName($domainName);
    if ($existing)
    {
      return $existing;
    }
    else
    {
      $newDomain = new DomainName($domainName);
      $this->entityManager->persist($newDomain);
      return $newDomain;
    }
  }
}
