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
use LegoW\LiterateSpoon\Component\Column;

/**
 * Description of ColumnTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ColumnTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $column = new Column();
        $this->assertSame('*', (string) $column);
    }

    public function testConstructorWithName()
    {
        $column = new Column('test');
        $this->assertSame('`test`', (string) $column);
    }

    public function testSetName()
    {
        $column = new Column();
        $this->assertSame('*', (string) $column);
        $snColumn = $column->setName('test');

        $this->assertSame('`test`', (string) $column);
        $this->assertSame($column, $snColumn);
    }
}
