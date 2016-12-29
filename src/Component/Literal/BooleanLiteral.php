<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Literal;

use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of BooleanLiteral
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class BooleanLiteral extends Literal
{
    protected $format;
    
    public function getFormat()
    {
        return $this->format ? 'true' : 'false';
    }
    
    public function __construct($value)
    {
        if(!is_bool($value)) {
            throw new \InvalidArgumentException('Only accepts bool value');
        }
        $this->format = $value;
        $possibleChildren = [];
        parent::__construct($possibleChildren);
    }

}
