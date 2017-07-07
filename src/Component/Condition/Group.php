<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Condition;

use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of SubWhere
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Group extends Condition
{

    const OP_AND = ' AND ';
    const OP_OR = ' OR ';
    const PARAM_NAME_CONDITIONS = 'conditions';

    public function getFormat()
    {
        return '(:' . self::PARAM_NAME_CONDITIONS . '-condition+)';
    }

    public function __construct($operator = self::OP_AND)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setOperator($operator);
    }

    /**
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
     * @param Condition $condition
     * @return $this
     */
    public function addCondition(Condition $condition)
    {
        $this->getParams()[self::PARAM_NAME_CONDITIONS]->addValue($condition);
        return $this;
    }

    /**
     * @param string $operator
     * @param Columns $column
     * @param Literal $value
     * @return $this
     */
    public function compare($operator, Columns $column, Literal $value)
    {
        $compare = new Condition\Compare($operator);
        $compare->setParam(Compare::PARAM_NAME_COLUMN, $column);
        $compare->setParam(Compare::PARAM_NAME_VALUE, $value);
        $this->addCondition($compare);
        return $this;
    }

}
