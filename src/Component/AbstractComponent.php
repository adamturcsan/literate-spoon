<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Param;

/**
 * Description of AbstractComponent
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
abstract class AbstractComponent implements ComponentInterface
{

    protected $multiple;
    protected $children = [];

    /**
     * @var Param[]
     */
    protected $params = [];
    protected $possibleChildren;
    protected $possibleParams;
    protected $paramGlue = ', ';
    protected $childGlue = ' ';

    public function __construct(array $possibleChildren)
    {
        $this->possibleChildren = $possibleChildren;
        $this->initParams($this->getFormat());
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritDoc}
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * {@inheritDoc}
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * {@inheritDoc}
     */
    public function setChild($name, ComponentInterface $component)
    {
        if (array_search($name, $this->possibleChildren) !== false) {
            $this->children[$name] = $component;
        }
        return $this;
    }

    public function hasChild($name)
    {
        if (array_key_exists($name, $this->children)) {
            return true;
        }
        return false;
    }

    public function getChild($name)
    {
        if ($this->hasChild($name)) {
            return $this->children[$name];
        }
    }

    public function setParam($name, ComponentInterface $value)
    {
        if (array_key_exists($name, $this->params)) {
            if (!$this->params[$name]->isMultiple()) {
                $this->params[$name]->setValue($value);
                return $this;
            }
            $this->params[$name]->addValue($value);
        }
        return $this;
    }

    public function __toString()
    {
        $string = $this->getFormat();
        /* @var $param Param */
        foreach ($this->params as $param) {
            $values = $param->getValues();
            if (count($values)) {
                $string = str_replace($param->getName(),
                        implode($this->paramGlue, $values), $string);
            } elseif ($param->isOptional()) {
                $string = str_replace($param->getName(), '', $string);
            }
        }
        $children = $this->getChildren();
        if (count($children)) {
            $string .= $this->childGlue . implode($this->childGlue,
                            $this->getChildren());
        }
        return $this->beautifyEndString($string);
    }

    protected function initParams($format)
    {
        $matches = null;
        preg_match_all('/(?<optional1>\[)?:(?<name>[a-zA-Z][a-zA-Z0-9_]*)-(?<type>[a-zA-Z_]+)(?<optional2>\])?(?<isMultiple>\+)?/',
                $format, $matches);

        foreach ($matches[0] as $key => $param) {
            $name = $matches['name'][$key];
            $type = $matches['type'][$key];
            $isMultiple = $matches['isMultiple'][$key] === '+';
            $isOptional = $matches['optional1'][$key] === '[' && $matches['optional2'][$key] === ']';
            $this->params[$name] = new Param($param, $type, $isOptional,
                    $isMultiple);
        }
    }
    
    /**
     * @param string $string
     * @return string
     */
    protected function beautifyEndString($string)
    {
        $endString = $string;
        while(strpos($endString, '  ') !== FALSE) {
            $endString = str_replace('  ', ' ', $endString);
        }
        return $endString;
    }

}
