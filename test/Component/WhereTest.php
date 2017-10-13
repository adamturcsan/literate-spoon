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
use LegoW\LiterateSpoon\Component\Condition\Compare;
use LegoW\LiterateSpoon\Component\Condition\Group;
use LegoW\LiterateSpoon\Component\Condition\In;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;
use LegoW\LiterateSpoon\Component\Where;
use PHPUnit\Framework\TestCase;

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
     * @expectedException InvalidArgumentException
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

        $condition = new Compare('=', new Column('test'), new Placeholder('testValue'));
        $condition2 = clone $condition;
        $condition2->setOperator('>');
        $where->group(Group::OP_OR)
                ->addCondition($condition)
                ->addCondition($condition2);

        $this->assertSame('WHERE ((`test` = :testValue) OR (`test` > :testValue))', (string)$where);
    }

    public function testInFluentBuilder()
    {
        $where = new Where();

        $whereIn = $where->in();
        $this->assertSame(
            'WHERE (:'.In::PARAM_NAME_COLUMN.'-column IN (:'.In::PARAM_NAME_ELEMENT.'-literal+))',
            (string)$where
        );
        $whereIn->setColumnName('test')
                ->addElementPlaceholder('elem1')
                ->addElementPlaceholder('elem2');
        $this->assertSame('WHERE (`test` IN (:elem1, :elem2))', (string)$where);
    }

    public function testInParametrizedFluentBuilder()
    {
        $where = new Where();

        $whereAfterIn = $where->columnInSet('test', [new Placeholder('elem1'), new Placeholder('elem2')]);
        $this->assertSame('WHERE (`test` IN (:elem1, :elem2))', (string)$where);
        $this->assertSame($where, $whereAfterIn);
    }
}
