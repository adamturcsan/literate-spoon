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
use LegoW\LiterateSpoon\Component\Where;
use LegoW\LiterateSpoon\Component\Condition\Compare;
use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

/**
 * Description of WhereTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class WhereTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $where = new Where();
        $this->assertSame('WHERE :'.Where::PARAM_NAME_CONDITIONS.'-condition+', (string)$where);
    }

    public function testSetOperator()
    {
        $where = new Where();
        $this->assertAttributeSame(Where::OP_AND, 'paramGlue', $where);
        $where->setOperator(Where::OP_OR);
        $this->assertAttributeSame(Where::OP_OR, 'paramGlue', $where);
    }

    public function testSetOperatorMethodChaining()
    {
        $where = new Where();
        $newWhere = $where->setOperator(Where::OP_OR);
        $this->assertSame($where, $newWhere);
        $this->assertAttributeSame(Where::OP_OR, 'paramGlue', $where);
    }

    /**
     * @depends testSetOperator
     */
    public function testOperatorConstructor()
    {
        $where = new Where(Where::OP_OR);
        $this->assertSame('WHERE :'.Where::PARAM_NAME_CONDITIONS.'-condition+', (string)$where);
        $this->assertAttributeSame(Where::OP_OR, 'paramGlue', $where);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetOperatorBadParam()
    {
        $where = new Where();
        $where->setOperator('XOR');
    }

    public function testAddCondition()
    {
        $condition = new Compare();
        $where = new Where();
        $afterWhere = $where->addCondition($condition);

        $this->assertSame('WHERE '.(string)$condition, (string)$where);
        $this->assertSame($where, $afterWhere);
    }

    /**
     * @depends testAddCondition
     */
    public function testCompare()
    {
        $where = new Where();

        $whereCmp = $where->compare('=', new Column('test'), new Placeholder('test'));

        $this->assertSame('WHERE (`test` = :test)', (string)$where);

        $this->assertSame($where, $whereCmp);
    }

    public function testCompareColumn()
    {
        $where = new Where();
        $whereCmp = $where->compareColumn('=', 'test1', ':testParam');

        $this->assertSame('WHERE (`test1` = :testParam)', (string)$where);
        $this->assertSame($where, $whereCmp);
    }

    public function testBetween()
    {
        $where = new Where();
        $whereB = $where->betweenColumn('test', 'first', 'second');

        $this->assertSame('WHERE (`test` BETWEEN :first AND :second)', (string)$where);
        $this->assertSame($where, $whereB);
    }

    public function testComplexCompareAndBetween()
    {
        $where = new Where();
        $whereB = $where->compareColumn('>', 'test1', ':param1')
                ->betweenColumn('test2', ':param2', ':param3');

        $this->assertSame('WHERE (`test1` > :param1) AND (`test2` BETWEEN :param2 AND :param3)', (string)$where);
        $this->assertSame($where, $whereB);
    }

    public function testGroupFluentBuilder()
    {
        $where = new Where();

        $condition = new Compare('=', new \LegoW\LiterateSpoon\Component\Column('test'), new Placeholder('testValue'));
        $condition2 = clone $condition;
        $condition2->setOperator('>');
        $where->group(\LegoW\LiterateSpoon\Component\Condition\Group::OP_OR)
                ->addCondition($condition)
                ->addCondition($condition2);

        $this->assertSame('WHERE ((`test` = :testValue) OR (`test` > :testValue))', (string)$where);
    }
}
