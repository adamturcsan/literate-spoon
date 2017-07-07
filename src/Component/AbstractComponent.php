<?php

/*
 * LegoW\LiterateSpoon (https://github.com/adamturcsan/literate-spoon)
 * 
 * @package legow/literate-spoon
 * @copyright Copyright (c) 2014-2017 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Param;
use LegoW\LiterateSpoon\ParamBuilder;

/**
 * Description of AbstractComponent
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
abstract class AbstractComponent implements ComponentInterface
{
    protected $children = [];

    /**
     * @var Param[]
     */
    protected $params = null;
    protected $possibleChildren;
    protected $possibleParams;
    protected $paramGlue = ', ';
    protected $childGlue = ' ';
    private $paramBuilder;

    public function __construct(array $possibleChildren, ParamBuilder $paramBuilder = null)
    {
        if($paramBuilder === null) {
            $this->paramBuilder = new ParamBuilder();
        }
        $this->possibleChildren = $possibleChildren;
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
        if($this->params === null) {
            $this->params = $this->paramBuilder->createFromFormat($this->getFormat());
        }
        return $this->params;
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
        return null;
    }

    public function setParam($name, ComponentInterface $value)
    {
        if (array_key_exists($name, $this->getParams())) {
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
        foreach ($this->getParams() as $param) {
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
    
    /**
     * @param string $string
     * @return string
     */
    private function beautifyEndString($string)
    {
        $endString = $string;
        while(strpos($endString, '  ') !== FALSE) {
            $endString = str_replace('  ', ' ', $endString);
        }
        return $endString;
    }

}
