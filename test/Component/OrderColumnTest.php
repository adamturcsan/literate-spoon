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
use LegoW\LiterateSpoon\Component\OrderColumn;
use LegoW\LiterateSpoon\Component\Direction;

/**
 * Description of OrderColumn
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class OrderColumnTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $orderColumn = new OrderColumn();
        $this->assertSame(':column-columns ASC', (string) $orderColumn);
    }

    public function testColumnConstructor()
    {
        $orderColumn = new OrderColumn('test');
        $this->assertSame('`test` ASC', (string) $orderColumn);
    }

    public function testColumnAndDirectionConstructor()
    {
        $orderColumn = new OrderColumn('test', Direction::DESC);
        $this->assertSame('`test` DESC', (string) $orderColumn);
    }
}
