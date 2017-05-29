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

/**
 * Description of SetColumn
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class SetColumn extends AbstractComponent
{
    const PARAM_NAME_COLUMN = 'column';
    const PARAM_NAME_VALUE = 'value';
    
    public function __construct($columnName = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        
        if($columnName !== null) {
            $this->setColumnName($columnName);
        }
    }
    
    public function getFormat()
    {
        return ':'.self::PARAM_NAME_COLUMN.'-column = :'.self::PARAM_NAME_VALUE.'-literal';
    }
    
    public function setColumn(Column $column)
    {
        $this->setParam(self::PARAM_NAME_COLUMN, $column);
        return $this;
    }
    
    public function setColumnName($columnName)
    {
        $column = new Column($columnName);
        return $this->setColumn($column);
    }
    
    public function setValue(Literal $value)
    {
        $this->setParam(self::PARAM_NAME_VALUE, $value);
        return $this;
    }
    
    public function setValueParamName($name)
    {
        $value = new Literal\Placeholder($name);
        return $this->setValue($value);
    }

}
