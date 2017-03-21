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
use LegoW\LiterateSpoon\Component\Select;
use LegoW\LiterateSpoon\Component\Condition\Compare;
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

/**
 * Description of SelectTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class SelectTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $select = new Select();
        $this->assertSame('SELECT * FROM :' . Select::PARAM_NAME_TABLE . '-table_name',
                (string) $select);
    }

    public function testSetTable()
    {
        $select = new Select();
        $select->setTableName('test');
        $this->assertSame('SELECT * FROM test', (string) $select);
    }

    /**
     * @depends testSetTable
     */
    public function testTableNameConstructor()
    {
        $select = new Select('test');
        $this->assertSame('SELECT * FROM test', (string) $select);
    }

    /**
     * @depends testTableNameConstructor
     */
    public function testSetColumns()
    {
        $select = new Select('test');
        $select->setColumns(['test', 'test2']);
        $this->assertSame('SELECT `test`, `test2` FROM test', (string) $select);
    }

    /**
     * @depends testSetColumns
     */
    public function testTableAndColumnsConstructor()
    {
        $select = new Select('test', ['test', 'test2']);
        $this->assertSame('SELECT `test`, `test2` FROM test', (string) $select);
    }

    /**
     * @depends testTableAndColumnsConstructor
     */
    public function testWhere()
    {
        $select = new Select('test', ['test', 'test2']);
        $select->where(new Compare('=', new Columns(['test']),
                new Placeholder('test')));

        $this->assertSame('SELECT `test`, `test2` FROM test WHERE (`test` = :test)',
                (string) $select);
    }

    /*
     * Testing abstract methods
     */

    public function testSetChild()
    {
        $select = new Select();
        $mockComponent = $this->createMock(\LegoW\LiterateSpoon\Component\ComponentInterface::class);

        $select->setChild('WHERE', $mockComponent);
        $this->assertAttributeContains($mockComponent, 'children', $select);
    }

    public function testGetNullChild()
    {
        $select = new Select();

        $this->assertNull($select->getChild('NonExistant'));
    }

    /**
     * @depends testSetChild
     */
    public function testGetChild()
    {
        $select = new Select();
        $mockComponent = $this->createMock(\LegoW\LiterateSpoon\Component\ComponentInterface::class);

        $select->setChild('WHERE', $mockComponent);
        $this->assertSame($mockComponent, $select->getChild('WHERE'));
    }

    //@todo Test setParam and getParams
}
