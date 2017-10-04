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
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\Column;

/**
 * Description of ColumnsTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ColumnsTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $columns = new Columns();

        $this->assertSame('*', (string) $columns);
    }

    public function testConstructorWithNameArray()
    {
        $columns = new Columns(['test1', 'test2']);

        $this->assertSame('`test1`, `test2`', (string) $columns);
    }

    public function testConstructorWithColumnArray()
    {
        $column1 = new Column('test1');
        $column2 = new Column('test2');

        $columns = new Columns([$column1, $column2]);

        $this->assertSame('`test1`, `test2`', (string) $columns);
    }

    public function testSetColumnsWithNameArray()
    {
        $columns = new Columns();
        $this->assertSame('*', (string) $columns);

        $scColumns = $columns->setColumns(['test1', 'test2']);
        $this->assertSame('`test1`, `test2`', (string) $columns);
        $this->assertSame($columns, $scColumns);
    }

    public function testSetColumnsWithColumnArray()
    {
        $columns = new Columns();
        $this->assertSame('*', (string) $columns);

        $column1 = new Column('test1');
        $column2 = new Column('test2');
        $scColumns = $columns->setColumns([$column1, $column2]);
        $this->assertSame('`test1`, `test2`', (string) $columns);
        $this->assertSame($columns, $scColumns);
    }
}
