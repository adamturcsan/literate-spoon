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

use InvalidArgumentException;
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
    protected $paramGlue = ', ';
    protected $childGlue = ' ';
    protected $format = '';
    private $paramBuilder;

    public function __construct(array $possibleChildren, ParamBuilder $paramBuilder = null)
    {
        if ($paramBuilder === null) {
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
        if ($this->params === null) {
            $this->params = $this->paramBuilder->createFromFormat($this->getFormat());
        }
        return $this->params;
    }

    /**
     * {@inheritDoc}
     */
    public function setChild($name, ComponentInterface $component)
    {
        if (array_search($name, $this->possibleChildren) === false) {
            throw new InvalidArgumentException(sprintf('Child name "%s" is not valid for this component', $name));
        }
        $this->children[$name] = $component;
        return $this;
    }

    public function hasChild($name)
    {
        if (array_key_exists($name, $this->children)) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getChild($name)
    {
        if ($this->hasChild($name)) {
            return $this->children[$name];
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setParam($name, ComponentInterface $value)
    {
        $param = $this->getParam($name);
        if ($param !== null) {
            if (! $param->isMultiple()) {
                $param->setValue($value);
                return $this;
            }
            $param->addValue($value);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getParam($name)
    {
        $params = $this->getParams();
        if (array_key_exists($name, $params)) {
            return $params[$name];
        }
        return null;
    }

    public function __toString()
    {
        $string = $this->getFormat();
        /* @var $param Param */
        foreach ($this->getParams() as $param) {
            $values = $param->getValues();
            if (count($values)) {
                $string = str_replace(
                    $param->getName(),
                    implode($this->paramGlue, $values),
                    $string
                );
            } elseif ($param->isOptional()) {
                $string = str_replace($param->getName(), '', $string);
            }
        }
        $children = $this->getChildren();
        if (count($children)) {
            $string .= $this->childGlue . implode(
                $this->childGlue,
                $this->getChildren()
            );
        }
        return $this->beautifyEndString($string);
    }

    /**
     * Rebuilds params list and sets the format
     * @param string $format
     */
    protected function setFormat($format)
    {
        $this->format = $format;
        $this->params = $this->paramBuilder->createFromFormat($this->format);
    }

    /**
     * @param string $string
     * @return string
     */
    private function beautifyEndString($string)
    {
        $endString = $string;
        while (strpos($endString, '  ') !== false) {
            $endString = str_replace('  ', ' ', $endString);
        }
        return $endString;
    }
}
