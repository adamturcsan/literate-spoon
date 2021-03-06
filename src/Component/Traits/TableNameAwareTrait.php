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

namespace LegoW\LiterateSpoon\Component\Traits;

use LegoW\LiterateSpoon\Component\ComponentInterface;
use LegoW\LiterateSpoon\Component\TableName;

/**
 * Description of TableNameAwareTrait
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
trait TableNameAwareTrait
{
    abstract public function setParam($name, ComponentInterface $param);
    /**
     * @param string $name
     * @return $this
     */
    public function setTableName($name)
    {
        $tableName = new TableName($name);
        $this->setParam(self::PARAM_NAME_TABLE, $tableName);
        return $this;
    }
}
