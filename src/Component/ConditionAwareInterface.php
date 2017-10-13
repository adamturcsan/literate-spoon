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
use LegoW\LiterateSpoon\Component\Condition\Group;
use LegoW\LiterateSpoon\Component\Condition\In;

/**
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
interface ConditionAwareInterface
{
    const OP_AND = ' AND ';
    const OP_OR = ' OR ';

    const PARAM_NAME_CONDITIONS = 'conditions';

    /**
     * @param string $operator
     * @return self
     * @throws InvalidArgumentException
     */
    public function setOperator($operator);

    /**
     * @param Condition $condition
     * @return self
     */
    public function addCondition(Condition $condition);

    /**
     * @param string $operator
     * @param Column $column
     * @param Literal $value
     * @return self
     */
    public function compare($operator, Column $column, Literal $value);

    /**
     * Sets a new compare condition with the given parameters
     * @param string $operator
     * @param string $columnName
     * @param string $paramName
     * @return self
     */
    public function compareColumn($operator, $columnName, $paramName);

    /**
     * Set a new between condition with the given parameters
     * @param string $columnName
     * @param string $firstParamName
     * @param string $secondParamName
     * @return self
     */
    public function betweenColumn($columnName, $firstParamName, $secondParamName);

    /**
     * Returns a new condition group attached to this Where instance
     * @param string $operator
     * @return Group
     */
    public function group($operator = self::OP_AND);

    /**
     * Returns a new 'in' condition
     * @return In
     */
    public function in();

    /**
     * Set a new 'in' condition with column name and initial elementset set
     * @param string $columnName
     * @param Literal[] $set
     * @return self
     */
    public function columnInSet($columnName, array $set);
}
