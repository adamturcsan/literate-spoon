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
 * Description of Columns
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Columns extends AbstractComponent
{
    const PARAM_NAME_COLUMN = 'column';

    /**
     * @var string
     */
    protected $format = '*';

    /**
     * {@inheritDoc}
     */
    public function getFormat()
    {
        return $this->format;
    }

    public function __construct(array $columns = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        if (! empty($columns)) {
            $this->setColumns($columns);
        }
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns)
    {
        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $this->setParam(self::PARAM_NAME_COLUMN, $column);
            } else {
                $this->setParam(self::PARAM_NAME_COLUMN, new Column($column));
            }
        }
        return $this;
    }

    public function setParam($name, ComponentInterface $value)
    {
        if ($name === self::PARAM_NAME_COLUMN && empty($this->params)) {
            $this->setFormatToHaveParams();
        }
        parent::setParam($name, $value);
    }

    private function setFormatToHaveParams()
    {
        $this->setFormat(':'.self::PARAM_NAME_COLUMN.'-column+');
    }
}
