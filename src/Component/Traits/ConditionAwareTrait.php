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

namespace LegoW\LiterateSpoon\Component\Traits;

use InvalidArgumentException;
use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Literal;
use ReflectionClass;

/**
 * Description of ConditionAwareTrait
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
trait ConditionAwareTrait
{
    abstract public function getParam($name);

    /**
     * @param string $operator
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setOperator($operator)
    {
        $reflection = new ReflectionClass($this);
        $constants = $reflection->getConstants();
        foreach ($constants as $name => $value) {
            if (substr($name, 0, 3) === 'OP_' && $value === $operator) {
                $this->paramGlue = $operator;
                return $this;
            }
        }
        throw new InvalidArgumentException('Not valid operator has been given');
    }

    /**
     * @param Condition $condition
     * @return self
     */
    public function addCondition(Condition $condition)
    {
        $this->getParam(self::PARAM_NAME_CONDITIONS)->addValue($condition);
        return $this;
    }

    /**
     * @param string $operator
     * @param Column $column
     * @param Literal $value
     * @return self
     */
    public function compare($operator, Column $column, Literal $value)
    {
        $compare = new Condition\Compare($operator);
        $compare->setParam('column', $column);
        $compare->setParam('value', $value);
        $this->addCondition($compare);
        return $this;
    }

    /**
     * Sets a new compare condition with the given parameters
     * @param string $operator
     * @param string $columnName
     * @param string $paramName
     * @return self
     */
    public function compareColumn($operator, $columnName, $paramName)
    {
        $columns = new Columns([$columnName]);
        $param = new Literal\Placeholder($paramName);
        return $this->compare($operator, $columns, $param);
    }

    /**
     * Set a new between condition with the given parameters
     * @param string $columnName
     * @param string $firstParamName
     * @param string $secondParamName
     * @return self
     */
    public function betweenColumn($columnName, $firstParamName, $secondParamName)
    {
        $between = new Condition\Between();
        $between->setColumnName($columnName)
                ->setFirstParam($firstParamName)
                ->setSecondParam($secondParamName);
        $this->addCondition($between);
        return $this;
    }

    /**
     * Returns a new condition group attached to this Where instance
     * @param string $operator
     * @return Group
     */
    public function group($operator = self::OP_AND)
    {
        $group = new Condition\Group($operator);
        $this->addCondition($group);
        return $group;
    }
}
