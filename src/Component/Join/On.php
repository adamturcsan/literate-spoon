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
use LegoW\LiterateSpoon\Component\Condition;

/**
 * Description of On
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class On extends AbstractComponent
{
    const PARAM_NAME_CONDITIONS = 'conditions';

    public function getFormat()
    {
        return 'ON :' . self::PARAM_NAME_CONDITIONS .'-condition';
    }

    public function __construct(Condition $condition = null)
    {
        parent::__construct([]);
        if ($condition !== null) {
            $this->setParam(self::PARAM_NAME_CONDITIONS, $condition);
        }
    }
}
