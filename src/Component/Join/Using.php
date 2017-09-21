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

namespace LegoW\LiterateSpoon\Component\Join;

use LegoW\LiterateSpoon\Component\AbstractComponent;
use LegoW\LiterateSpoon\Component\Column;

/**
 * Description of Using
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Using extends AbstractComponent
{
    const PARAM_NAME_COLUMN_NAME = 'column';

    public function getFormat()
    {
        return 'USING :' . self::PARAM_NAME_COLUMN_NAME . '-column';
    }

    public function __construct($columnName = null)
    {
        parent::__construct([]);
        if ($columnName !== null) {
            $this->setColumnName($columnName);
        }
    }

    public function setColumnName($name)
    {
        $column = new Column($name);
        $this->setParam(self::PARAM_NAME_COLUMN_NAME, $column);
        return $this;
    }
}
