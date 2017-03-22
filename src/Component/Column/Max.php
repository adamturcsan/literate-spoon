<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Column;

use LegoW\LiterateSpoon\Component\Columns;

/**
 * Description of Max
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Max extends Columns
{

    const PARAM_NAME_COLUMNS = 'column';

    /**
     * @return string
     */
    public function getFormat()
    {
        return "MAX(:".self::PARAM_NAME_COLUMNS."-columns)";
    }

    public function __construct(array $columns = null)
    {
        if ($columns !== null && count($columns) > 1) {
            throw new \InvalidArgumentException('Only one column is accepted as parameter');
        }
        parent::__construct();
        if ($columns !== null) {
            $columnsComponent = new Columns($columns);
            $this->setParam(self::PARAM_NAME_COLUMNS, $columnsComponent);
        }
    }

}
