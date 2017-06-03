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

namespace LegoW\LiterateSpoon\Component\Traits;

use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Where;

/**
 * Description of WhereableTrait
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
trait WhereableTrait
{

    /**
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
}
