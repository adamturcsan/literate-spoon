<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Column;

use LegoW\LiterateSpoon\Component\Columns;
/**
 * Description of Custom
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Custom extends Columns
{
    protected $format;
    
    public function getFormat()
    {
        return $this->format;
    }
    
    public function __construct($value = null)
    {
        $this->setValue($value);
    }
    
    public function setValue($value)
    {
        $this->format = $value;
    }
}
