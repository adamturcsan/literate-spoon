<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Component\Traits\TableNameAwareTrait;
use LegoW\LiterateSpoon\Component\Traits\WhereableTrait;
use LegoW\LiterateSpoon\Component\WhereableInterface;
use LegoW\LiterateSpoon\Component\TableNameAwareInterface;

/**
 * Description of Select
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Select extends AbstractComponent implements WhereableInterface, TableNameAwareInterface
{
    use WhereableTrait;
    use TableNameAwareTrait;

    const CHILD_JOIN = 'JOIN';
    const CHILD_ORDER_BY = 'ORDERBY';
    const CHILD_HAVING = 'HAVING';
    const CHILD_LIMIT = 'LIMIT';
    const PARAM_NAME_COLUMNS = 'columns';

    public function getFormat()
    {
        return 'SELECT :' . self::PARAM_NAME_COLUMNS . '-columns FROM :' . self::PARAM_NAME_TABLE . '-table_name';
    }

    /**
     * @param string $tableName
     * @param string[] $columns
     */
    public function __construct($tableName = null, array $columns = null)
    {
        $possibleChildren = [
            self::CHILD_JOIN,
            self::CHILD_WHERE,
            self::CHILD_ORDER_BY,
            self::CHILD_HAVING,
            self::CHILD_LIMIT
        ];
        parent::__construct($possibleChildren);
        if ($tableName !== null) {
            $this->setTableName($tableName);
        }
        if ($columns === null) {
            $this->setDefaultColumns();
        } else {
            $this->setColumns($columns);
        }
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

    protected function setDefaultColumns()
    {
        $columns = new Columns();
        $this->setParam(self::PARAM_NAME_COLUMNS, $columns);
    }

    /**
     * @param OrderColumn $orderColumn
     * @return OrderBy
     */
    public function orderBy(OrderColumn $orderColumn = null)
    {
        $order = $this->hasChild(self::CHILD_ORDER_BY) ? $this->getChild(self::CHILD_ORDER_BY) : new OrderBy();
        if ($orderColumn !== null) {
            $order->addOrderColumn($orderColumn);
        }
        $this->setChild(self::CHILD_ORDER_BY, $order);
        return $order;
    }

    /**
     * @param int $num
     * @param int $offset
     * @return $this
     */
    public function limit($num = 1, $offset = 0)
    {
        /* @var $limit Limit */
        $limit = $this->hasChild(self::CHILD_LIMIT) ? $this->getChild(self::CHILD_LIMIT) : new Limit();
        $limit->setLimit($num, $offset);
        $this->setChild(self::CHILD_LIMIT, $limit);
        return $this;
    }

    /**
     * @param string $tableName
     * @param string $type
     * @return Join
     */
    public function join($tableName = null, $type = null)
    {
        $joinComponent = $this->hasChild(self::CHILD_JOIN) ? $this->getChild(self::CHILD_JOIN) :
                         new Join($tableName, $type);
        $this->setChild(self::CHILD_JOIN, $joinComponent);
        return $joinComponent;
    }
}
