<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Notice;
use Doctrine\ORM\QueryBuilder;

class NoticeRepository extends BaseRepository
{
    /**
     * @param int|null $id
     * @return Notice|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOne($id)
    {
        $queryBuilder = $this->repository->createQueryBuilder('n')
            ->select('n,c')
            ->leftJoin('n.contributor', 'c')
            ->where('n.id = :id')
            ->andWhere('c.enabled = true')
            ->setParameter('id', $id);

        return self::addNoticeExpirationLogic($queryBuilder)
            ->getQuery()->getOneOrNullResult()
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $noticeAlias
     * @return QueryBuilder
     */
    public static function addNoticeExpirationLogic(QueryBuilder $queryBuilder, $noticeAlias = 'n')
    {
        return $queryBuilder->andWhere(sprintf('%s.expires >= CURRENT_TIMESTAMP() OR %s.expires IS NULL OR (%s.expires <= CURRENT_TIMESTAMP() AND %s.unpublishedOnExpiration = false)',
                    $noticeAlias, $noticeAlias, $noticeAlias, $noticeAlias)
        );
    }

    /**
     * @return string
     */
    public function getResourceClassName()
    {
        return Notice::class;
    }
}