<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of Where
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Where extends AbstractComponent
{

    const OP_AND = ' AND ';
    const OP_OR = ' OR ';

    const PARAM_NAME_CONDITIONS = 'conditions';

    public function getFormat()
    {
        return 'WHERE :'.self::PARAM_NAME_CONDITIONS.'-condition+';
    }

    public function __construct($operator = self::OP_AND)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setOperator($operator);
    }

    /**
     *
     * @param string $operator
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setOperator($operator)
    {
        $reflection = new \ReflectionClass($this);
        $constants = $reflection->getConstants();
        foreach ($constants as $name => $value) {
            if (substr($name, 0, 3) === 'OP_' && $value === $operator) {
                $this->paramGlue = $operator;
                return $this;
            }
        }
        throw new \InvalidArgumentException('Not valid operator has been given');
    }

    /**
     * @param \LegoW\LiterateSpoon\Component\Condition $condition
     * @return $this
     */
    public function addCondition(Condition $condition)
    {
        $this->getParams()[self::PARAM_NAME_CONDITIONS]->addValue($condition);
        return $this;
    }

    /**
     * @param string $operator
     * @param \LegoW\LiterateSpoon\Component\Columns $column
     * @param \LegoW\LiterateSpoon\Component\Literal $value
     * @return $this
     */
    public function compare($operator, Columns $column, Literal $value)
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
     * @return $this
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
     * @return $this
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
     * @return \LegoW\LiterateSpoon\Component\Condition\Group
     */
    public function group($operator = self::OP_AND)
    {
        $group = new Condition\Group($operator);
        $this->addCondition($group);
        return $group;
    }
}
