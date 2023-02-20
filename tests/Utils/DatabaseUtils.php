<?php

namespace Neo\Tests\Utils;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

trait DatabaseUtils
{
    protected function getOneBy(string $entityClass, array $criteria): object
    {
        $object = $this->getEm()->getRepository($entityClass)->findOneBy($criteria);
        if ($object === null) {
            $keys = implode(",", array_keys($criteria));
            throw new \RuntimeException(sprintf('Not found entity "%s" by criteria %s', $entityClass, $keys));
        }
        return $object;
    }

    protected function deleteAllObjects(string $entityClass): void
    {
        $this->getEm()->createQuery('DELETE FROM ' . $entityClass)->execute();
    }


    protected function getEm(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        return $em;
    }
}
