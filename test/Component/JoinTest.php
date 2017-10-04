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

use InvalidArgumentException;
use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\ComponentInterface;
use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Join;
use LegoW\LiterateSpoon\Component\Join\On;
use LegoW\LiterateSpoon\Component\Join\Using;
use PHPUnit\Framework\TestCase;

/**
 * Description of JoinTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class JoinTest extends TestCase
{
    public function testConstructionWithoutParams()
    {
        $join = new Join();
        $expected = ' JOIN :'.Join::PARAM_NAME_TABLE.'-table_name';
        $this->assertSame($expected, (string)$join);
    }

    public function testConstructionWithWrongType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Non-valid type');
        new Join(null, 'wrongType');
    }

    public function testConstructionWithParams()
    {
        $join = new Join('testTable', Join::TYPE_LEFT);
        $expected = ' LEFT JOIN testTable';
        $this->assertSame($expected, (string)$join);
    }

    public function testSetType()
    {
        $join = new Join();
        $afterJoin = $join->setType(Join::TYPE_INNER);
        $this->assertSame(' INNER JOIN :'.Join::PARAM_NAME_TABLE.'-table_name', (string)$join);
        $this->assertSame($join, $afterJoin);
    }

    public function testSetChildWithWrongChildName()
    {
        $this->expectException(InvalidArgumentException::class);
        $join = new Join();
        $join->setChild('wrong', $this->createMock(ComponentInterface::class));
    }

    public function testSetChildWithOn()
    {
        $join = new Join();
        $join->setChild(Join::CHILD_ON, $this->createMock(ComponentInterface::class));
        $this->assertTrue($join->hasChild(Join::CHILD_ON));
    }

    public function testSetChildWithUsing()
    {
        $join = new Join();
        $join->setChild(Join::CHILD_USING, $this->createMock(ComponentInterface::class));
        $this->assertTrue($join->hasChild(Join::CHILD_USING));
    }

    public function testSetChildWithUsingAndOn()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Only one should be used');
        $join = new Join();
        $join->setChild(Join::CHILD_USING, $this->createMock(ComponentInterface::class));
        $join->setChild(Join::CHILD_ON, $this->createMock(ComponentInterface::class));
        $this->assertTrue($join->hasChild(Join::CHILD_USING));
        $this->assertFalse($join->hasChild(Join::CHILD_ON));
    }

    public function testSetChildWithOnAndUsing()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Only one should be used');
        $join = new Join();
        $join->setChild(Join::CHILD_ON, $this->createMock(ComponentInterface::class));
        $join->setChild(Join::CHILD_USING, $this->createMock(ComponentInterface::class));
        $this->assertFalse($join->hasChild(Join::CHILD_USING));
        $this->assertTrue($join->hasChild(Join::CHILD_ON));
    }

    public function testFluidOn()
    {
        $join = new Join('test');
        $on = $join->on();
        $this->assertInstanceOf(On::class, $on);
        $this->assertSame('ON :'.On::PARAM_NAME_CONDITIONS.'-condition', (string)$on);
        $on->setParam(On::PARAM_NAME_CONDITIONS, $this->createMock(Condition::class));
        $this->assertSame('ON ', (string)$on);
        $this->assertSame('ON ', (string)$join->on());
        $this->assertSame(' JOIN test ON ', (string)$join);
    }

    public function testFluidUsing()
    {
        $join = new Join('test');
        $using = $join->using();
        $this->assertInstanceOf(Using::class, $using);
        $this->assertSame('USING (:'.Using::PARAM_NAME_COLUMN_NAME.'-column)', (string)$using);
        $using->setParam(Using::PARAM_NAME_COLUMN_NAME, $this->createMock(Column::class));
        $this->assertSame('USING ()', (string)$using);
        $this->assertSame('USING ()', (string)$join->using());
        $this->assertSame(' JOIN test USING ()', (string)$join);
    }

    public function testSetTableName()
    {
        $join = new Join();
        $afterJoin = $join->setTableName('test');
        $this->assertSame(' JOIN test', (string)$join);
        $this->assertSame($join, $afterJoin);
    }
}
