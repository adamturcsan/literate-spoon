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

use LegoW\LiterateSpoon\Component\Columns;

/**
 * Description of OrderColumn
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class OrderColumn extends AbstractComponent
{

    const PARAM_NAME_COLUMN = 'column';
    const PARAM_NAME_DIRECTION = 'direction';

    /**
     * @return string
     */
    public function getFormat()
    {
        return ':' . self::PARAM_NAME_COLUMN . '-columns :' . self::PARAM_NAME_DIRECTION . '-direction';
    }

    public function __construct($columnName = null, $direction = 'ASC')
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setParam(self::PARAM_NAME_DIRECTION, new Direction($direction));
        if ($columnName !== null) {
            $this->setColumn($columnName);
        }
    }

    private function setColumn($columnName)
    {
        $column = new Columns([$columnName]);
        $this->setParam(self::PARAM_NAME_COLUMN, $column);
    }
}
