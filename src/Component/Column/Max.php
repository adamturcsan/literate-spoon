<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Column;

use LegoW\LiterateSpoon\Component\Column;

/**
 * Description of Max
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Max extends Column
{

    const PARAM_NAME_COLUMNS = 'column';

    /**
     * @return string
     */
    public function getFormat()
    {
        return "MAX(:".self::PARAM_NAME_COLUMNS."-column)";
    }

    /**
     * @param string $column
     */
    public function __construct($column = null)
    {
        parent::__construct();
        if ($column !== null) {
            $columnsComponent = new Column($column);
            $this->setParam(self::PARAM_NAME_COLUMNS, $columnsComponent);
        }
    }
}
