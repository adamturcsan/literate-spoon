<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of InertColumns
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class InsertColumns extends AbstractComponent
{
    const PARAM_NAME_COLUMNS = 'columns';

    /**
     * {@inheritDoc}
     */
    public function getFormat()
    {
        return '(:'.self::PARAM_NAME_COLUMNS.'-columns)';
    }

    public function __construct(array $columns = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        if ($columns !== null) {
            $this->setColumns($columns);
        }
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns)
    {
        $this->setParam(self::PARAM_NAME_COLUMNS, new Columns($columns));
    }
}
