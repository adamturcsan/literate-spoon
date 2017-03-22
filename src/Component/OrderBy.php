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
 * Description of OrderBy
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class OrderBy extends AbstractComponent
{

    const PARAM_NAME_COLUMN_ORDER = 'ordercolumn';

    public function __construct()
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
    }

    public function getFormat()
    {
        return 'ORDER BY :' . self::PARAM_NAME_COLUMN_ORDER . '-order_column+';
    }

    /**
     * @param \LegoW\LiterateSpoon\Component\OrderColumn $order
     * @return $this
     */
    public function addOrderColumn(OrderColumn $order)
    {
        $this->setParam(self::PARAM_NAME_COLUMN_ORDER, $order);
        return $this;
    }
    
    /**
     * @param string $name
     * @param string $direction
     * @return $this
     */
    public function setOrder($name, $direction)
    {
        $orderColumn = new OrderColumn($name, $direction);
        $this->addOrderColumn($orderColumn);
        return $this;
    }

}
