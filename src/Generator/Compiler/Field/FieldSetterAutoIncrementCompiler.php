<?php declare(strict_types=1);

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Orm\Generator\Compiler\Field;

use Eureka\Component\Orm\Generator\Compiler\AbstractFieldCompiler;
use Eureka\Component\Orm\Generator\Compiler\Context;

/**
 * Field Setter for auto-increment id compiler class
 *
 * @author Romain Cottard
 */
class FieldSetterAutoIncrementCompiler extends AbstractFieldCompiler
{
    /**
     * FieldSetterAutoIncrementCompiler constructor.
     *
     * @param Field $field
     */
    public function __construct(Field $field)
    {
        parent::__construct(
            $field,
            [
                __DIR__ . '/../../Templates/FieldSetterAutoIncrement.template' => false,
            ]
        );
    }

    /**
     * @param Context $context
     * @param bool $isAbstract
     * @return Context
     */
    protected function updateContext(Context $context, bool $isAbstract = false): Context
    {
        $exception  = '';

        if ($this->field->hasValidationAuto() || $this->field->hasValidation()) {
            $exception = "\n     * @throws ValidationException";
        }

        $context
            ->add('property.setter', $this->getNameForSetter($this->field))
            ->add('property.exception', $exception)
        ;

        return $context;
    }
}