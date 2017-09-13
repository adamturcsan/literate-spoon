<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon;

use LegoW\LiterateSpoon\Component\ComponentInterface;

/**
 * Description of Param
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Param
{

    /**
     * Indicates whether parameter is optional
     * @var bool
     */
    private $optional;

    /**
     * Indicates whether parameter can have multiple values
     * @var bool
     */
    private $multiple;

    /**
     * Parameter name
     * @var string
     */
    private $name;

    /**
     * Parameter value(s)
     * @var ComponentInterface[]
     */
    private $values;

    /**
     * Classname of type the param accepts as value
     * @var string
     */
    private $type;

    /**
     * @param string $name
     * @param bool $isOptional
     * @param bool $multiple
     */
    public function __construct($name, $type, $isOptional, $multiple)
    {
        $this->name = $name;
        $this->setType($type);
        $this->optional = (bool) $isOptional;
        $this->multiple = (bool) $multiple;
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return $this->optional;
    }

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param ComponentInterface $value
     * @return $this
     */
    public function setValue(ComponentInterface $value)
    {
        if (! $value instanceof $this->type) {
            throw new \InvalidArgumentException('Wrong value type was provided: '.get_class($value));
        }
        if (! $this->isMultiple()) {
            $this->values[0] = $value;
        }
        return $this;
    }

    public function addValue(ComponentInterface $value)
    {
        if (! $value instanceof $this->type) {
            throw new \InvalidArgumentException('Wrong value type was provided: '.get_class($value));
        }
        if ($this->isMultiple()) {
            $this->values[] = $value;
        }
        return $this;
    }

    /**
     * @return ComponentInterface[]
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $typeName Type name from format string
     * @return string Actual Class name with fullnamespace
     */
    private function setType($typeName)
    {
        $componentNamespace = 'LegoW\\LiterateSpoon\\Component\\';
        $stdulyCaps = str_replace(
            ' ',
            '',
            ucwords(str_replace('_', ' ', $typeName))
        );
        $className = $componentNamespace . $stdulyCaps;
        if (! class_exists($className)) {
            throw new \RuntimeException('Given Component type (' . $typeName . ') doesn\'t exists for Param');
        }
        $this->type = $className;
    }
}
