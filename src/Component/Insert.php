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
    protected $format = 'INSERT INTO :table-table_name [:columns-insert_columns] VALUES (:value-literal+)';
    
    /**
     * 
     * @param string $tableName
     */
    public function __construct($tableName = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        if($tableName != null) {
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
        $this->setParam('table', $tableName);
    }
}
