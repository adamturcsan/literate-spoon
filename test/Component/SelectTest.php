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

use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\ComponentInterface;
use LegoW\LiterateSpoon\Component\Condition\Compare;
use LegoW\LiterateSpoon\Component\Direction;
use LegoW\LiterateSpoon\Component\Join;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;
use LegoW\LiterateSpoon\Component\OrderBy;
use LegoW\LiterateSpoon\Component\OrderColumn;
use LegoW\LiterateSpoon\Component\Select;
use LegoW\LiterateSpoon\Component\TableName;
use LegoW\LiterateSpoon\Component\Where;
use LegoW\LiterateSpoon\Param;
use PHPUnit\Framework\TestCase;

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
        $this->assertSame(
            'SELECT * FROM :' . Select::PARAM_NAME_TABLE . '-table_name',
            (string) $select
        );
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
        $selectAfter = $select->setColumns(['test', 'test2']);
        $this->assertSame('SELECT `test`, `test2` FROM test', (string) $select);
        $this->assertSame($select, $selectAfter);
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
        $select->where(new Compare(
            '=',
            new Column('test'),
            new Placeholder('test')
        ));

        $this->assertSame(
            'SELECT `test`, `test2` FROM test WHERE (`test` = :test)',
            (string) $select
        );
    }

    public function testWhereMethodChaining()
    {
        $select = new Select('test', ['test', 'test2']);
        $select->where(new Compare('=', new Column('test'), new Placeholder('test')))
                ->setOperator(Where::OP_OR)
                ->addCondition(new Compare('<', new Column('test2'), new Placeholder('test2')));
        $this->assertSame(
            'SELECT `test`, `test2` FROM test WHERE (`test` = :test) OR (`test2` < :test2)',
            (string) $select
        );
    }

    /*
     * Testing abstract methods
     */

    public function testSetChild()
    {
        $select = new Select();
        $mockComponent = $this->createMock(ComponentInterface::class);

        $selectAfter = $select->setChild('WHERE', $mockComponent);
        $this->assertAttributeContains($mockComponent, 'children', $select);
        $this->assertSame($select, $selectAfter);
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
        $mockComponent = $this->createMock(ComponentInterface::class);

        $select->setChild('WHERE', $mockComponent);
        $this->assertSame($mockComponent, $select->getChild('WHERE'));
    }

    public function testSetOrder()
    {
        $select = new Select('test', ['test1', 'test2']);
        $select->orderBy()->setOrder('test1', Direction::DESC);
        $this->assertSame('SELECT `test1`, `test2` FROM test ORDER BY `test1` DESC', (string)$select);
    }

    public function testOrderByColumn()
    {
        $select = new Select('test', ['test1']);
        $orderColumn = new OrderColumn('test1', Direction::DESC);
        $order = $select->orderBy($orderColumn);
        $this->assertSame('SELECT `test1` FROM test ORDER BY `test1` DESC', (string)$select);
        $this->assertInstanceOf(OrderBy::class, $order);
    }

    public function testLimit()
    {
        $select = new Select('test', ['test1', 'test2']);
        $selectAfter = $select->limit(3, 6);
        $this->assertSame($select, $selectAfter);
    }

    public function testGetParams()
    {
        $component = new Select();
        $params = $component->getParams();
        $this->assertCount(2, $params);
        $this->assertContainsOnly(Param::class, $params);
    }

    public function testSetParams()
    {
        $select = new Select();
        $mockedTableName = $this->createMock(TableName::class);
        $afterSelect = $select->setParam(
            Select::PARAM_NAME_TABLE,
            $mockedTableName
        );
        $this->assertSame($select, $afterSelect);
        $this->assertSame($select->getParam(Select::PARAM_NAME_TABLE)->getValue(), $mockedTableName);
        $afterSelect2 = $select->setParam(
            'NonExistantParam',
            $mockedTableName
        );
        $this->assertSame($select, $afterSelect2);
    }

    public function testJoin()
    {
        $select = new Select('test', ['test1']);
        $join = $select->join();
        $this->assertInstanceOf(Join::class, $join);
        $join->setTableName('testTable');
        $this->assertSame((string)$join, (string)$select->join());
        $this->assertSame('SELECT `test1` FROM test JOIN testTable', (string)$select);
    }
}
