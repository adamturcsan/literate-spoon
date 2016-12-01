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
}
