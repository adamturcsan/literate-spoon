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

namespace LegoW\LiterateSpoon\Component\Condition;

use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of Between
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Between extends Condition
{

    const PARAM_NAME_COLUMN = 'column';
    const PARAM_NAME_FIRST = 'first';
    const PARAM_NAME_SECOND = 'second';

    /**
     * @return string
     */
    public function getFormat()
    {
        return '(:'
               . self::PARAM_NAME_COLUMN . '-column BETWEEN '
               . ':' . self::PARAM_NAME_FIRST . '-literal AND '
               . ':' . self::PARAM_NAME_SECOND . '-literal'
               . ')';
    }

    public function __construct()
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
    }

    /**
     * @param Column $column
     * @return $this
     */
    public function setColumn(Column $column)
    {
        $this->setParam(self::PARAM_NAME_COLUMN, $column);
        return $this;
    }

    /**
     * @param string $columnName
     * @return $this
     */
    public function setColumnName($columnName)
    {
        $this->setColumn(new Column($columnName));
        return $this;
    }

    /**
     * @param Literal $value
     * @return $this
     */
    public function setFirst(Literal $value)
    {
        $this->setParam(self::PARAM_NAME_FIRST, $value);
        return $this;
    }

    /**
     * @param string $paramName
     * @return $this
     */
    public function setFirstParam($paramName)
    {
        $this->setParam(self::PARAM_NAME_FIRST, new Literal\Placeholder($paramName));
        return $this;
    }

    /**
     * @param Literal $value
     * @return $this
     */
    public function setSecond(Literal $value)
    {
        $this->setParam(self::PARAM_NAME_SECOND, $value);
        return $this;
    }

    /**
     * @param string $paramName
     * @return $this
     */
    public function setSecondParam($paramName)
    {
        $this->setParam(self::PARAM_NAME_SECOND, new Literal\Placeholder($paramName));
        return $this;
    }
}
