<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of TableName
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class TableName extends AbstractComponent
{

    protected $format = '';

    public function getFormat()
    {
        return $this->format;
    }

    /**
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        if (!is_string($name)) {
            throw new \InvalidArgumentException('TableName\'s name must be a string');
        }
        $this->format = $name;
    }

}
