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

namespace LegoW\LiterateSpoon\Test\Component;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\OrderBy;
use LegoW\LiterateSpoon\Component\OrderColumn;
use LegoW\LiterateSpoon\Component\Direction;

/**
 * Description of OrderByTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class OrderByTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $orderBy = new OrderBy();
        $this->assertSame('ORDER BY :ordercolumn-order_column+', (string)$orderBy);
        return $orderBy;
    }

    /**
     * @depends testDefaultConstructor
     * @param OrderBy $orderBy
     */
    public function testAddOrder(OrderBy $orderBy)
    {
        $orderBy->addOrderColumn(new OrderColumn('test', Direction::DESC));
        $this->assertSame('ORDER BY `test` DESC', (string)$orderBy);
    }

    public function testMultipleOrderColumn()
    {
        $orderBy = new OrderBy();
        $orderBy->addOrderColumn(new OrderColumn('test1'))
                ->addOrderColumn(new OrderColumn('test2', Direction::DESC));
        $this->assertSame('ORDER BY `test1` ASC, `test2` DESC', (string)$orderBy);
    }

    public function testAddOrderColumn()
    {
        $orderBy = new OrderBy();
        $orderColumn = new OrderColumn('test', Direction::DESC);
        $orderBy->addOrderColumn($orderColumn);
        $this->assertSame('ORDER BY `test` DESC', (string)$orderBy);
    }

    public function testSetOrder()
    {
        $orderBy = new OrderBy();
        $soOrderBy = $orderBy->setOrder('test', Direction::DESC);
        $this->assertSame('ORDER BY `test` DESC', (string)$orderBy);
        $this->assertSame($orderBy, $soOrderBy, 'Test if it returns itself');
    }
}
