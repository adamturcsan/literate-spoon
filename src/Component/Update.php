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

use LegoW\LiterateSpoon\Component\WhereableInterface;
use LegoW\LiterateSpoon\Component\Traits\WhereableTrait;
use LegoW\LiterateSpoon\Component\Traits\TableNameAwareTrait;

/**
 * Description of Update
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Update extends AbstractComponent implements WhereableInterface, TableNameAwareInterface
{
    use WhereableTrait;
    use TableNameAwareTrait;

    const PARAM_NAME_SET_COLUMN = 'column';

    public function getFormat()
    {
        return 'UPDATE :'.self::PARAM_NAME_TABLE.'-table_name '
                . 'SET :'.self::PARAM_NAME_SET_COLUMN.'-set_column+';
    }

    public function __construct($tableName = null)
    {
        $possibleChildren = [self::CHILD_WHERE];
        parent::__construct($possibleChildren);
        if ($tableName !== null) {
            $this->setTableName($tableName);
        }
    }

    public function addSetColumn(SetColumn $column)
    {
        $this->setParam(self::PARAM_NAME_SET_COLUMN, $column);
        return $this;
    }

    public function set($columnName, $valueParamName)
    {
        $setColumn = new SetColumn($columnName);
        $setColumn->setValueParamName($valueParamName);
        return $this->addSetColumn($setColumn);
    }
}
