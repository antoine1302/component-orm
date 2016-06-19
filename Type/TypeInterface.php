<?php

/**
 * Copyright (c) 2010-2016 Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Orm\Type;

/**
 * Type interface
 *
 * @author Romain Cottard
 * @version 2.0.0
 */
interface TypeInterface
{
    /**
     * Get cast db string ((int), (bool)...)
     *
     * @return string
     */
    public function getCastDb();

    /**
     * Get cast method string ((int), (bool)...)
     *
     * @return string
     */
    public function getCastMethod();

    /**
     * Get type string (int, bool...)
     * @return string
     */
    public function getType();

    /**
     * Get empty value for this type.
     *
     * @return boolean
     */
    public function getEmptyValue();

    /**
     * If type is unsigned
     *
     * @return boolean
     */
    public function isUnsigned();
}
