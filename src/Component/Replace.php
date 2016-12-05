<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of Replace
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Replace extends Insert
{

    protected $format = "REPLACE INTO :table-table_name [:columns-column_values] VALUES (:value-literal+)";

    public function getFormat()
    {
        $format = parent::getFormat();
        return str_replace('INSERT INTO', 'REPLACE INTO', $format);
    }

}
