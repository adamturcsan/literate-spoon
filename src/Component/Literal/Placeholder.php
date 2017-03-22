<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Literal;

use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of Placeholder
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Placeholder extends Literal
{
    protected $format;

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    public function __construct($value)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setFormat($value);
    }
    
    protected function setFormat($value)
    {
        if(substr($value, 0, 1) == ':') {
            $this->format = $value;
            return;
        }
        $this->format = ':'.$value;
    }
}
