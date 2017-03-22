<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Literal;

use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of String
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class StringLiteral extends Literal
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
        $this->format = '"' . $value . '"';
        $possibleChildren = [];
        parent::__construct($possibleChildren);
    }

}
