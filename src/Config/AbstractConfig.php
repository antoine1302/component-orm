<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Orm\Config;

/**
 * Abstract Data Mapper config class for db/table orm generator.
 *
 * @author  Romain Cottard
 */
abstract class AbstractConfig implements ConfigInterface
{
    /** @var bool $hasCache If use cache in orm classes */
    protected $hasCache = false;

    /** @var string $author Comment author name <email> */
    protected $author = '';

    /** @var string $copyright Comment copyright entity name.s */
    protected $copyright = '';

    /** @var string $classname Base class name of generated classes. */
    protected $classname = '';

    /** @var string $baseNamespaceForData */
    protected $baseNamespaceForData = '';

    /** @var string $baseNamespaceForMapper */
    protected $baseNamespaceForMapper = '';

    /** @var string $basePathForData */
    protected $basePathForData = '';

    /** @var string $basePathForMapper */
    protected $basePathForMapper = '';

    /** @var string $dbConfig Database config name. */
    protected $dbConfig = '';

    /** @var string $dbTable Table name */
    protected $dbTable = '';

    /** @var string $dbPrefix Table prefix to remove from method name. */
    protected $dbPrefix = '';

    /** @var string $cacheName Cache name config. */
    protected $cacheName = '';

    /** @var string $cachePrefix Cache name prefix. */
    protected $cachePrefix = '';

    /** @var ConfigInterface[] $joinList List of joined config. */
    protected $joinList = array();

    /**
     * Initialize config.
     *
     * @param  array $config
     * @return $this
     */
    abstract protected function init($config);

    /**
     * Init config & validate it.
     *
     * @param  array $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        $this->init($config);
        $this->validate();
    }

    /**
     * Get Header file author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get Header file author.
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Get Header file version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get classname for the generated files
     *
     * @return string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * Get database config name (catalog, catalog_import...)
     *
     * @return string
     */
    public function getDbConfig()
    {
        return strtolower($this->dbConfig);
    }

    /**
     * Get database table to generate.
     *
     * @return string
     */
    public function getDbTable()
    {
        return $this->dbTable;
    }

    /**
     * Get database table prefix.
     *
     * @return string
     */
    public function getDbPrefix()
    {
        return $this->dbPrefix;
    }

    /**
     * Return true if cache is active, false in otherwise.
     *
     * @return bool
     */
    public function hasCache()
    {
        return $this->hasCache;
    }

    /**
     * Get cache name to use.
     *
     * @return string
     */
    public function getCacheName()
    {
        return $this->cacheName;
    }

    /**
     * Get cache prefix for main data key.
     *
     * @return string
     */
    public function getCachePrefix()
    {
        return $this->cachePrefix;
    }

    /**
     * Get Config object(s) for "joined" tables
     *
     * @return ConfigInterface[]
     */
    public function getAllJoin()
    {
        return $this->joinList;
    }

    /**
     * Get base namespace for "data" files for generated files.
     *
     * @return string
     */
    public function getBaseNamespaceForData()
    {
        return $this->baseNamespaceForData;
    }

    /**
     * Get base namespace for "mapper" files for generated files.
     *
     * @return string
     */
    public function getBaseNamespaceForMapper()
    {
        return $this->baseNamespaceForMapper;
    }

    /**
     * Get base path for "data" files for generated files.
     *
     * @return string
     */
    public function getBasePathForData()
    {
        return trim($this->basePathForData, '/\\');
    }

    /**
     * Get base path for "mapper" files for generated files.
     *
     * @return string
     */
    public function getBasePathForMapper()
    {
        return trim($this->basePathForMapper, '/\\');
    }

    /**
     * Check if config has required values.
     *
     * @return $this
     * @throws \Exception
     */
    protected function validate()
    {
        if (empty($this->author)) {
            throw new \Exception('Author is empty!');
        }

        if (empty($this->classname)) {
            throw new \Exception('Class name is empty!');
        }

        if (empty($this->dbConfig)) {
            throw new \Exception('Database config name is empty!');
        }

        if (empty($this->dbTable)) {
            throw new \Exception('Database table name is empty!');
        }

        /*if (empty($this->cacheName)) {
            throw new \Exception('Cache name is empty!');
        }*/

        if (empty($this->cachePrefix)) {
            throw new \Exception('Cache prefix is empty!');
        }

        if (empty($this->baseNamespaceForData)) {
            throw new \Exception('Data namespace is empty!');
        }

        if (empty($this->baseNamespaceForMapper)) {
            throw new \Exception('Mapper namespace is empty!');
        }

        if (empty($this->basePathForData)) {
            throw new \Exception('Data path is empty!');
        }

        if (empty($this->basePathForMapper)) {
            throw new \Exception('Mapper path is empty!');
        }

        return $this;
    }

    /**
     * @param  Config[] $joinList
     * @return void
     */
    public function setJoinList($joinList)
    {
        $this->joinList = $joinList;
    }
}