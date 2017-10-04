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
     * @return ComponentInterface If param is multiple it returns the first value
     */
    public function getValue()
    {
        return $this->getValueAt(0);
    }

    /**
     * @param int $offset
     * @return ComponentInterface
     */
    public function getValueAt($offset)
    {
        return $this->getValues()[$offset];
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
     * @return bool
     */
    public function hasValue()
    {
        return ! empty($this->getValues());
    }

    /**
     * @param string $typeFormat Type name from format string,
     *                         which is a snakecase class name with double underscores (__) as namespace separator
     * @return string Actual Class name with fullnamespace
     */
    private function setType($typeFormat)
    {
        $fqcn = $this->getTypeFromFormat($typeFormat);
        $this->type = $fqcn;
    }

    private function getTypeFromFormat($typeFormat)
    {
        $componentNamespace = 'LegoW\\LiterateSpoon\\Component\\';
        $relativeName = $this->getRelativeClassNameFromTypeFormat($typeFormat);
        $fqcn = $componentNamespace . $relativeName;
        if (! class_exists($fqcn)) {
            throw new \RuntimeException('Given Component type (' . $typeFormat . ') doesn\'t exists for Param');
        }
        return $fqcn;
    }

    /**
     * From type format like "namespace__class_name" creates "Namespace\ClassName"
     * @param string $typeFormat
     * @return string
     */
    private function getRelativeClassNameFromTypeFormat($typeFormat)
    {
        $withNameSpaces = str_replace('__', '\\ ', $typeFormat);
        $studlyCaps = ucwords(str_replace('_', ' ', $withNameSpaces));
        $className = str_replace(' ', '', $studlyCaps);
        return $className;
    }
}
