<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Component\TableName;

/**
 * Description of Insert
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Insert extends AbstractComponent
{

    const PARAM_NAME_TABLE = 'table';
    const PARAM_NAME_COLUMNS = 'columns';
    const PARAM_NAME_VALUES = 'value';

    protected $format = 'INSERT INTO :' . self::PARAM_NAME_TABLE . '-table_name '
            . '[:' . self::PARAM_NAME_COLUMNS . '-insert_columns]'
            . ' VALUES (:' . self::PARAM_NAME_VALUES . '-literal+)';

    /**
     * 
     * @param string $tableName
     */
    public function __construct($tableName = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        if ($tableName != null) {
            $this->setTableName($tableName);
        }
    }

    public function getFormat()
    {
        return $this->format;
    }

    /**
     * 
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $tableName = new TableName($tableName);
        $this->setParam(self::PARAM_NAME_TABLE, $tableName);
    }

}
