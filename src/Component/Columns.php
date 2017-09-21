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
        $columnsWithBackTick = [];
        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $columnsWithBackTick[] = (string)$column;
            } else {
                $columnsWithBackTick[] = '`'.$column.'`';
            }
        }
        $this->format = implode(', ', $columnsWithBackTick);
        return $this;
    }
}
