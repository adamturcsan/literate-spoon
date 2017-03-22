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

namespace LegoW\LiterateSpoon\Test\Component\Condition;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Condition\Between;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

/**
 * Description of BetweenTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class BetweenTest extends TestCase
{
    public function testShouldBeACondition()
    {
        $between = new Between();
        $this->assertInstanceOf(\LegoW\LiterateSpoon\Component\Condition::class, $between);
    }

    public function testDefaultConstructor()
    {
        $between = new Between();
        $this->assertSame('(:' . Between::PARAM_NAME_COLUMN . '-column BETWEEN :' . Between::PARAM_NAME_FIRST . '-literal AND :' . Between::PARAM_NAME_SECOND . '-literal)',
                (string) $between);
    }

    public function testSetColumn()
    {
        $between = new Between();
        $column = new \LegoW\LiterateSpoon\Component\Column('test1');

        $scBetween = $between->setColumn($column);
        $this->assertSame('(`test1` BETWEEN :' . Between::PARAM_NAME_FIRST . '-literal AND :' . Between::PARAM_NAME_SECOND . '-literal)',
                (string) $between);
        $this->assertSame($between, $scBetween);
    }

    public function testSetColumnName()
    {
        $between = new Between();

        $scBetween = $between->setColumnName('test1');
        $this->assertSame('(`test1` BETWEEN :' . Between::PARAM_NAME_FIRST . '-literal AND :' . Between::PARAM_NAME_SECOND . '-literal)',
                (string) $between);
        $this->assertSame($between, $scBetween);
    }

    public function testSetFirst()
    {
        $between = new Between();

        $spBetween = $between->setFirst(new Placeholder('param1'));
        $this->assertSame('(:' . Between::PARAM_NAME_COLUMN . '-column BETWEEN :param1 AND :' . Between::PARAM_NAME_SECOND . '-literal)',
                (string) $between);
        $this->assertSame($between, $spBetween);
    }

    public function testSetSecond()
    {
        $between = new Between();

        $spBetween = $between->setSecond(new Placeholder('param2'));
        $this->assertSame('(:' . Between::PARAM_NAME_COLUMN . '-column BETWEEN :' . Between::PARAM_NAME_FIRST . '-literal AND :param2)',
                (string) $between);
        $this->assertSame($between, $spBetween);
    }

    public function testSetFirstParam()
    {
        $between = new Between();

        $spBetween = $between->setFirstParam('param1');
        $this->assertSame('(:' . Between::PARAM_NAME_COLUMN . '-column BETWEEN :param1 AND :' . Between::PARAM_NAME_SECOND . '-literal)',
                (string) $between);
        $this->assertSame($between, $spBetween);
    }

    public function testSetSecondParam()
    {
        $between = new Between();

        $spBetween = $between->setSecondParam('param2');
        $this->assertSame('(:' . Between::PARAM_NAME_COLUMN . '-column BETWEEN :' . Between::PARAM_NAME_FIRST . '-literal AND :param2)',
                (string) $between);
        $this->assertSame($between, $spBetween);
    }

}
