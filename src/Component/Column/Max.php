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

    public function getFormat()
    {
        return "MAX(:column-columns)";
    }

    public function __construct(array $columns = null)
    {
        if ($columns !== null && count($columns) > 1) {
            throw new \InvalidArgumentException('Only one column is accepted as parameter');
        }
        parent::__construct();
        if ($columns !== null) {
            $columnsComponent = new Columns($columns);
            $this->setParam('column', $columnsComponent);
        }
    }

}
