<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Literal;

use LegoW\LiterateSpoon\Component\Literal;
/**
 * Description of ColumnLiteral
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ColumnLiteral extends Literal
{
    protected $format;
    
    public function getFormat()
    {
        return $this->format;
    }
    
    public function __construct($value)
    {
        $this->format = '`'.$value.'`';
        $possibleChildren = [];
        parent::__construct($possibleChildren);
    }
}
