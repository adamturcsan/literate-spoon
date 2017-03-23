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

    const CHiLD_JOIN = 'JOIN';
    const CHILD_WHERE = 'WHERE';
    const CHILD_ORDER_BY = 'ORDERBY';
    const CHILD_HAVING = 'HAVING';
    const CHILD_LIMIT = 'LIMIT';
    const PARAM_NAME_COLUMNS = 'columns';
    const PARAM_NAME_TABLE = 'table';

    public function getFormat()
    {
        return 'SELECT :' . self::PARAM_NAME_COLUMNS . '-columns FROM :' . self::PARAM_NAME_TABLE . '-table_name';
    }

    public function __construct($tableName = null, array $columns = null)
    {
        $possibleChildren = [self::CHiLD_JOIN, self::CHILD_WHERE, self::CHILD_ORDER_BY, self::CHILD_HAVING, self::CHILD_LIMIT];
        parent::__construct($possibleChildren);
        if ($tableName !== null) {
            $this->setTableName($tableName);
        }
        if ($columns == null) {
            $this->setDefaultColumns();
        } else {
            $this->setColumns($columns);
        }
    }

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

    /**
     * @param string[] $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $columnsComponent = new Columns($columns);
        $this->setParam(self::PARAM_NAME_COLUMNS, $columnsComponent);
        return $this;
    }

    /**
     * 
     * @param \LegoW\LiterateSpoon\Component\Condition $condition
     * @param string $operator
     * @return Where
     */
    public function where(Condition $condition = null, $operator = Where::OP_AND)
    {
        $where = $this->hasChild('WHERE') ? $this->getChild('WHERE') : new Where($operator);
        if ($condition !== null) {
            $where->addCondition($condition);
        }
        $this->setChild('WHERE', $where);
        return $where;
    }

    protected function setDefaultColumns()
    {
        $columns = new Columns();
        $this->setParam(self::PARAM_NAME_COLUMNS, $columns);
    }

    /**
     * @param \LegoW\LiterateSpoon\Component\OrderColumn $orderColumn
     * @return \LegoW\LiterateSpoon\Component\OrderBy
     */
    public function orderBy(OrderColumn $orderColumn = null)
    {
        $order = $this->hasChild(self::CHILD_ORDER_BY) ? $this->getChild(self::CHILD_ORDER_BY) : new OrderBy();
        if ($orderColumn !== null) {
            $order->addOrderColumn($orderColumn);
        }
        $this->setChild('ORDERBY', $order);
        return $order;
    }
    
    public function limit($num = 1, $offset = 0)
    {
        /* @var $limit Limit */
        $limit = $this->hasChild(self::CHILD_LIMIT) ? $this->getChild(self::CHILD_LIMIT) : new Limit();
        $limit->setLimit($num, $offset);
        $this->setChild(self::CHILD_LIMIT, $limit);
        return $this;
    }

}
