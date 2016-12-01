<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of Columns
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Columns extends AbstractComponent
{
    protected $format = '*';
    
    /**
     * {@inheritDoc}
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    public function __construct(array $columns = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        if($columns != null) {
            $this->setColumns($columns);
        }
    }
    
    /**
     * @param array $columns
     */
    public function setColumns(array $columns)
    {
        $columnsWithBackTick = array_map(function($v){return '`'.$v.'`';}, $columns);
        $this->format = implode(', ', $columnsWithBackTick);
    }
}
