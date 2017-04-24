<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Component\TableName;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

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

    /**
     * @return string
     */
    public function getFormat()
    {
        return 'INSERT INTO :' . self::PARAM_NAME_TABLE . '-table_name '
            . '[:' . self::PARAM_NAME_COLUMNS . '-insert_columns]'
            . ' VALUES (:' . self::PARAM_NAME_VALUES . '-literal+)';
    }

    /**
     * 
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $tableName = new TableName($tableName);
        $this->setParam(self::PARAM_NAME_TABLE, $tableName);
        return $this;
    }
    
    /**
     * Add one column to the insert statement
     * @param string $columnName
     * @return $this
     */
    public function addColumn($columnName)
    {
        $columns = new InsertColumns([$columnName]);
        $this->setParam(self::PARAM_NAME_COLUMNS, $columns);
        return $this;
    }
    
    public function addColumns(array $columns)
    {
        $columnsObj = new InsertColumns($columns);
        $this->setParam(self::PARAM_NAME_COLUMNS, $columnsObj);
        return $this;
    }
    
    /**
     * Add <b>:placeHolderName</b> style placeholder helping further
     * value bindig mechanisms
     * @param string $name
     * @return $this
     */
    public function addValuePlaceHolderFor($name)
    {
        $placeHolder = new Placeholder($name);
        $this->setParam(self::PARAM_NAME_VALUES, $placeHolder);
        return $this;
    }

}
