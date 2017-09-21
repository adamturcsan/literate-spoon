<?php

/*
 * All rights reserved © 2017 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

/**
 * Description of Union
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Union extends AbstractComponent
{

    const PARAM_NAME_SELECT = 'select';

    /**
     * @return string
     */
    public function getFormat()
    {
        return ':' . self::PARAM_NAME_SELECT . '-select+';
    }

    public function __construct()
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->paramGlue = ' UNION ';
    }

    /**
     * @param Select $select
     * @return $this
     */
    public function addSelect(Select $select)
    {
        $this->setParam(self::PARAM_NAME_SELECT, $select);
        return $this;
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @return Select
     */
    public function addNewSelect($tableName, array $columns)
    {
        $select = new Select($tableName, $columns);
        $this->addSelect($select);
        return $select;
    }
}
