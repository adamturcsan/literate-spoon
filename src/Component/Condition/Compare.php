<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Condition;

use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of Compare
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Compare extends Condition
{
    public function getFormat()
    {
        return '(:column-columns '.$this->getOperator().' :value-literal)';
    }
    
    public function __construct($operator = '=', Columns $columns = null, Literal $value = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setOperator($operator);
        if($columns != null) {
            $this->setParam('column', $columns);
        }
        if($value != null) {
            $this->setParam('value', $value);
        }
    }
    
    public function getOperator()
    {
        return $this->paramGlue;
    }

    public function setOperator($operator)
    {
        $this->paramGlue = $operator;
        return $this;
    }


}
