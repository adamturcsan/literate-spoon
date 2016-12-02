<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

declare (strict_types = 1);

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of InertColumns
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class InsertColumns extends AbstractComponent
{
    protected $format = '(:columns-columns)';
    
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
        $this->setParam('columns', new Columns($columns));
    }
}
