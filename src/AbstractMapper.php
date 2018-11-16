<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Orm;

use Eureka\Component\Database\Connection;
use Eureka\Component\Orm\Query;
use Eureka\Component\Orm\Traits;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;

/**
 * DataMapper Mapper abstract class.
 *
 * @author Romain Cottard
 */
abstract class AbstractMapper implements RepositoryInterface
{
    use Traits\ConnectionAwareTrait, Traits\MapperTrait, Traits\RepositoryTrait, Traits\EntityAwareTrait, Traits\CacheAwareTrait, Traits\ValidatorAwareTrait;

    /**
     * Initialize mapper with proper values for mapped table.
     */
    abstract protected function initialize(): void;

    /**
     * AbstractMapper constructor.
     *
     * @param \Eureka\Component\Database\Connection $connection
     * @param \Psr\Container\ContainerInterface $validatorFactoryContainer
     * @param \Eureka\Component\Orm\AbstractMapper[] $mappers
     * @param \Psr\Cache\CacheItemPoolInterface|null $cache
     * @param bool $enableCacheOnRead
     */
    public function __construct(Connection $connection, ContainerInterface $validatorFactoryContainer = null, $mappers = [], CacheItemPoolInterface $cache = null, $enableCacheOnRead = false)
    {
        $this->setConnection($connection);
        $this->setCache($cache);
        $this->setValidatorFactoryContainer($validatorFactoryContainer);

        $this->addMappers($mappers);

        if ($enableCacheOnRead) {
            $this->enableCacheOnRead();
        }

        $this->initialize();
    }

    /**
     * @param callable $callback
     * @param \Eureka\Component\Orm\Query\SelectBuilder $queryBuilder
     * @param string $key
     * @param int $start
     * @param int $end
     * @param int $batchSize
     * @return void
     * @throws \Eureka\Component\Orm\Exception\OrmException
     */
    public function apply(callable $callback, Query\SelectBuilder $queryBuilder, string $key, int $start = 0, int $end = -1, int $batchSize = 10000)
    {
        if (!in_array($key, $this->primaryKeys)) {
            throw new \UnexpectedValueException(__METHOD__ . ' | The key must be a primary key.');
        }

        $statement = $this->connection->prepare('SELECT MIN(' . $key . ') AS MIN, MAX(' . $key . ') AS MAX FROM ' . $this->getTable());
        $statement->execute();

        $bounds = $statement->fetch(Connection::FETCH_OBJ);

        $minIndex          = max($start, $bounds->MIN);
        $maxIndex          = $end < 0 ? $bounds->MAX : min($end, $bounds->MAX);
        $currentBatchIndex = $minIndex;

        while ($currentBatchIndex <= $maxIndex) {
            /** @var \Eureka\Component\Orm\RepositoryInterface $this */
            $clonedQueryBuilder = clone Query\Factory::getBuilder(Query\Factory::TYPE_SELECT, $this);
            $clonedQueryBuilder->addWhere($key, $currentBatchIndex, '>=')
                ->addWhere($key, $currentBatchIndex + $batchSize, '<')
            ;

            $batch = $this->query($clonedQueryBuilder);

            foreach ($batch as $item) {
                call_user_func($callback, $item);
            }

            $currentBatchIndex += $batchSize;
        }
    }
}
