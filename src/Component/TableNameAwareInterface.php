<?php

/*
 * LegoW\LiterateSpoon (https://github.com/adamturcsan/literate-spoon)
 *
 * @package legow/literate-spoon
 * @copyright Copyright (c) 2014-2017 Legow Hosting Kft. (http://www.legow.hu)
 * @license https://opensource.org/licenses/MIT MIT License
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
interface TableNameAwareInterface
{
    const PARAM_NAME_TABLE = 'table';

    /**
     * @param string $tableName
     * @return self
     */
    public function setTableName($tableName);
}
