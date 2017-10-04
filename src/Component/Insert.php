<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Component\TableName;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;
use LegoW\LiterateSpoon\Component\Traits\TableNameAwareTrait;

/**
 * Description of Insert
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Insert extends AbstractComponent implements TableNameAwareInterface
{
    use TableNameAwareTrait;

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
        if ($tableName !== null) {
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
     * Add one column to the insert statement
     * @param string $columnName
     * @return $this
     */
    public function addColumn($columnName)
    {
        $param = $this->getParam(self::PARAM_NAME_COLUMNS);
        if ($param->hasValue()) {
            $param->getValue()->setParam(InsertColumns::PARAM_NAME_COLUMNS, new Column($columnName));
            return $this;
        }
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
