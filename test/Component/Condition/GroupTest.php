<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Condition;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Condition\Group;
use LegoW\LiterateSpoon\Component\Column\Custom;
use LegoW\LiterateSpoon\Component\Literal\StringLiteral;

/**
 * Description of GroupTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class GroupTest extends TestCase
{

    public function testDefaultConstruct()
    {
        $groupCondition = new Group();
        $this->assertSame('(:conditions-condition+)', (string) $groupCondition);
    }

    public function testOperatorConstruct()
    {
        $groupCondition = new Group(Group::OP_OR);
        $this->assertAttributeSame(Group::OP_OR, 'paramGlue', $groupCondition);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadOperatorConstruct()
    {
        $groupCondition = new Group('=');
    }

    public function testSetOperator()
    {
        $groupCondition = new Group();
        $this->assertAttributeSame(Group::OP_AND, 'paramGlue', $groupCondition);
        $soGroupCondition = $groupCondition->setOperator(Group::OP_OR);
        $this->assertAttributeSame(Group::OP_OR, 'paramGlue', $groupCondition);
        $this->assertSame($groupCondition, $soGroupCondition,
                'Test if it returns itself');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetWrongOperator()
    {
        $groupCondition = new Group();
        $groupCondition->setOperator('=');
    }

    public function testChainingCompare()
    {
        $groupCondition = new Group();
        $cGroupCondition = $groupCondition->compare('=', new Custom('test'),
                new StringLiteral('test'));
        $this->assertSame('((test = "test"))', (string) $groupCondition);
        $this->assertSame($groupCondition, $cGroupCondition,
                'Test if it returns itself');

        $groupCondition
                ->compare('>', new Custom('test2'), new StringLiteral('test2'))
                ->compare('<', new Custom('test3'), new StringLiteral('test3'));
        $this->assertSame('((test = "test") AND (test2 > "test2") AND (test3 < "test3"))',
                (string) $groupCondition);
    }

}
