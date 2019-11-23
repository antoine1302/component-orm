<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Orm\Config;

/**
 * Data Mapper config interface for db/table orm generator.
 *
 * @author Romain Cottard
 */
interface ConfigInterface
{
    /**
     * Get Header file author.
     *
     * @return string
     */
    public function getAuthor(): string;

    /**
     * Get Header file copyright
     *
     * @return string
     */
    public function getCopyright(): string;

    /**
     * Get base namespace for "entity" files for generated files.
     *
     * @return string
     */
    public function getBaseNamespaceForEntity(): string;

    /**
     * Get base namespace for "mapper" files for generated files.
     *
     * @return string
     */
    public function getBaseNamespaceForMapper(): string;

    /**
     * Get base namespace for "repository" files for generated files.
     *
     * @return string
     */
    public function getBaseNamespaceForRepository(): string;

    /**
     * Get base path for "entity" files for generated files.
     *
     * @return string
     */
    public function getBasePathForEntity(): string;

    /**
     * Get base path for "mapper" files for generated files.
     *
     * @return string
     */
    public function getBasePathForMapper(): string;

    /**
     * Get base path for "repository" files for generated files.
     *
     * @return string
     */
    public function getBasePathForRepository(): string;

    /**
     * Get classname for the generated files
     *
     * @return string
     */
    public function getClassname(): string;

    /**
     * Get database table to generate.
     *
     * @return string
     */
    public function getDbTable(): string;

    /**
     * Get database table prefix(es).
     *
     * @return string[]
     */
    public function getDbPrefix(): array;

    /**
     * Return true if cache is active, false in otherwise.
     *
     * @return bool
     */
    public function hasCache(): bool;

    /**
     * Get cache prefix for main data key.
     *
     * @return string
     */
    public function getCachePrefix(): string;

    /**
     * Get validation config.
     *
     * @return array
     */
    public function getValidation(): array;

    /**
     * Get Config object(s) for "joined" tables
     *
     * @return array
     */
    public function getAllJoin(): array;

    /**
     * @param  ConfigInterface[] $joinList
     * @return $this
     */
    public function setJoinList(array $joinList): ConfigInterface;
}
