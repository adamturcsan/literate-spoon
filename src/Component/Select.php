<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of Select
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Select extends AbstractComponent
{
    
    public function getFormat()
    {
        return 'SELECT :columns-columns FROM :table-table_name';
    }

    public function __construct($tableName = null, array $columns = null)
    {
        $possibleChildren = ['JOIN','WHERE','ORDERBY','HAVING','LIMIT'];
        parent::__construct($possibleChildren);
        if($tableName !== null) {
            $this->setTableName($tableName);
        }
        if($columns == null) {
            $this->setDefaultColumns();
        } else {
            $this->setColumns($columns);
        }
    }
    
    public function setTableName($name)
    {
        $tableName = new TableName($name);
        $this->setParam('table', $tableName);
        return $this;
    }
    
    public function setColumns(array $columns)
    {
        $columnsComponent = new Columns($columns);
        $this->setParam('columns', $columnsComponent);
        return $this;
    }
    
    public function where(Condition $condition, $operator = Where::OP_AND)
    {
        $where = $this->hasChild('WHERE') ? $this->getChild('WHERE') : new Where($operator);
        $where->addCondition($condition);
        $this->setChild('WHERE', $where);
    }
    
    protected function setDefaultColumns()
    {
        $columns = new Columns();
        $this->setParam('columns', $columns);
    }
}
