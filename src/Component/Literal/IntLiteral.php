<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Literal;

use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of IntLiteral
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class IntLiteral extends Literal
{

    protected $format;

    /**
     * @return string
     */
    public function getFormat()
    {
        return (string) $this->format;
    }

    public function __construct($value)
    {
        $this->format = (int) $value;
        $possibleChildren = [];
        parent::__construct($possibleChildren);
    }
}
