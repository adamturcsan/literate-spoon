<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Condition;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Condition\Compare;
use LegoW\LiterateSpoon\Component\Column;

/**
 * Description of Compare
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CompareTest extends TestCase
{

    public function testDefaultConstruct()
    {
        $compareCondition = new Compare();
        $this->assertSame('(:column-column = :value-literal)',
                (string) $compareCondition);
    }

    public function testOperatorConstruct()
    {
        $compareCondition = new Compare('>');
        $this->assertSame('(:column-column > :value-literal)',
                (string) $compareCondition);
        $compareCondition2 = new Compare('<=');
        $this->assertSame('(:column-column <= :value-literal)',
                (string) $compareCondition2);
    }

    public function testColumnsConstruct()
    {
        $column = new Column\Custom('test');
        $compareCondition = new Compare('=', $column);
        $this->assertSame('(test = :value-literal)', (string) $compareCondition);
    }

    public function testValueConstruct()
    {
        $column = new Column\Custom('test');
        $value = new \LegoW\LiterateSpoon\Component\Literal\BooleanLiteral(true);
        $compareCondition = new Compare('=', $column, $value);
        $this->assertSame('(test = true)', (string) $compareCondition);
    }
    
    public function testGetOperator()
    {
        $compareCondition = new Compare();
        $this->assertSame('=', $compareCondition->getOperator());
        $compareCondition2 = new Compare('>=');
        $this->assertSame('>=', $compareCondition2->getOperator());
    }
    
    /**
     * @depends testGetOperator
     */
    public function testSetOperator()
    {
        $compareCondition = new Compare();
        $compareCondition->setOperator('>=');
        $this->assertSame('>=', $compareCondition->getOperator());
        $soCompareCondition = $compareCondition->setOperator('<>');
        $this->assertSame('<>', $compareCondition->getOperator());
        $this->assertSame($compareCondition, $soCompareCondition, 'Test if it returns itself');
    }

}
