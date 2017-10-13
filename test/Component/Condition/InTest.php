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

declare (strict_types = 1);

namespace LegoW\LiterateSpoon\Test\Component\Condition;

use LegoW\LiterateSpoon\Component\Condition\In;
use LegoW\LiterateSpoon\Component\Literal\IntLiteral;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Description of InTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class InTest extends TestCase
{
    public function testNullConstruct()
    {
        $in = new In();
        $this->assertInstanceOf(In::class, $in);
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (:'.In::PARAM_NAME_ELEMENT.'-literal+))', (string)$in);
    }

    public function testElementsConstruct()
    {
        $in = new In(null, [new IntLiteral(1), new IntLiteral(2)]);
        $this->assertInstanceOf(In::class, $in);
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (1, 2))', (string)$in);
    }

    public function testColumnNameConstruct()
    {
        $in = new In('test');
        $this->assertInstanceOf(In::class, $in);
        $this->assertSame('(`test` IN (:'.In::PARAM_NAME_ELEMENT.'-literal+))', (string)$in);
    }
    public function testElementsConstructWithWrongTypes()
    {
        $this->expectException(TypeError::class);
        new In(null, [1,2]);
    }

    public function testAddElements()
    {
        $in = new In();
        $afterAddIn = $in->addElements([new IntLiteral(1), new IntLiteral(3)]);
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (1, 3))', (string)$in);
        $this->assertSame($in, $afterAddIn);
    }

    public function testAddElement()
    {
        $in = new In();
        $in->addElement(new IntLiteral(1));
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (1))', (string)$in);
        $afterAddIn = $in->addElement(new IntLiteral(3));
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (1, 3))', (string)$in);
        $this->assertSame($in, $afterAddIn);
    }

    public function testAddPlaceholderElement()
    {
        $in = new In();
        $in->addElementPlaceholder('elem1');
        $in->addElementPlaceholder('elem2');
        $afterAddIn = $in->addElementPlaceholder('elem3');
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (:elem1, :elem2, :elem3))', (string)$in);
        $this->assertSame($in, $afterAddIn);
    }

    public function testSetColumnName()
    {
        $in = new In();
        $afterSetIn = $in->setColumnName('test');
        $this->assertSame('(`test` IN (:'.In::PARAM_NAME_ELEMENT.'-literal+))', (string)$in);
        $this->assertSame($in, $afterSetIn);
    }

    public function testSetNullColumnName()
    {
        $in = new In();
        $afterSetIn = $in->setColumnName(null);
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (:'.In::PARAM_NAME_ELEMENT.'-literal+))', (string)$in);
        $this->assertSame($in, $afterSetIn);
    }

    public function testAddNullElements()
    {
        $in = new In();
        $afterAddIn = $in->addElements(null);
        $this->assertSame('(:'.In::PARAM_NAME_COLUMN.'-column IN (:'.In::PARAM_NAME_ELEMENT.'-literal+))', (string)$in);
        $this->assertSame($in, $afterAddIn);
    }

    public function testFullParameterConstruct()
    {
        $in = new In('test', [new IntLiteral(1), new Placeholder('elem')]);
        $this->assertSame('(`test` IN (1, :elem))', (string)$in);
    }

    public function testAllSet()
    {
        $in = new In();
        $in->setColumnName('test');
        $in->addElementPlaceholder('elem');
        $in->addElement(new IntLiteral(2));
        $this->assertSame('(`test` IN (:elem, 2))', (string)$in);
    }
}
