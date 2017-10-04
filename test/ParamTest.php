<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Param;
use LegoW\LiterateSpoon\Component;

/**
 * Description of ParamTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 * @coversDefaultClass LegoW\LiterateSpoon\Param
 */
class ParamTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::setType
     * @return Param
     */
    public function testDefaultConstructor()
    {
        $param = new Param('parameter', 'Literal', true, true);
        $this->assertInstanceOf(Param::class, $param);
        $this->assertAttributeEquals('parameter', 'name', $param);
        $this->assertAttributeEquals(Component\Literal::class, 'type', $param);
        $this->assertAttributeEquals(true, 'optional', $param);
        $this->assertAttributeEquals(true, 'multiple', $param);
        return $param;
    }

    /**
     * @depends testDefaultConstructor
     * @covers ::isOptional
     * @param Param $param
     */
    public function testIsOptional(Param $param)
    {
        $this->assertEquals(true, $param->isOptional());
    }

    /**
     * @depends testDefaultConstructor
     * @covers ::isMultiple
     * @param Param $param
     */
    public function testIsMultiple(Param $param)
    {
        $this->assertEquals(true, $param->isMultiple());
    }

    /**
     * @depends testDefaultConstructor
     * @covers ::setValue
     * @param Param $param
     */
    public function testSetValueForMultiple(Param $param)
    {
        $value = new Component\Literal\StringLiteral('string');
        $param->setValue($value);
        $this->assertAttributeEquals(null, 'values', $param);
    }

    /**
     * @covers ::setValue
     */
    public function testSetValue()
    {
        $param = new Param('name', 'Literal', false, false);
        $value = new Component\Literal\StringLiteral('string');
        $setParam = $param->setValue($value);
        $this->assertAttributeEquals([$value], 'values', $param);
        $this->assertSame($param, $setParam, 'Param::setValue returns self');
    }

    /**
     * @covers ::setValue
     * @expectedException \InvalidArgumentException
     */
    public function testSetValueWithWrongValue()
    {
        $param = new Param('name', 'Literal', false, false);
        $value = new Component\Columns(['string']);
        $param->setValue($value);
        $this->assertAttributeEquals([$value], 'values', $param);
    }

    /**
     * @depends testDefaultConstructor
     * @param Param $param
     * @covers ::addValue
     */
    public function testAddValue(Param $param)
    {
        $value = new Component\Literal\StringLiteral('string');
        $paramAdd = $param->addValue($value);
        $this->assertSame($param, $paramAdd);
        $paramAdd->addValue($value);
        $this->assertSame([$value, $value], $param->getValues());
        return $param;
    }

    /**
     * @depends testDefaultConstructor
     * @param Param $param
     * @covers ::addValue
     * @expectedException \InvalidArgumentException
     */
    public function testAddWrongValue(Param $param)
    {
        $value = new Component\Columns(['string']);
        $param->addValue($value);
    }

    /**
     * @covers ::getValues
     */
    public function testGetValues()
    {
        $param = new Param('name', 'Literal', true, true);
        $value = new Component\Literal\StringLiteral('string');
        $param->addValue($value);
        $this->assertEquals([$value], $param->getValues());
    }

    /**
     * @depends testDefaultConstructor
     * @covers ::getName
     * @param Param $param
     */
    public function testGetName(Param $param)
    {
        $this->assertEquals('parameter', $param->getName());
    }

    /**
     * @covers ::setType
     * @expectedException \RuntimeException
     */
    public function testWrongSetType()
    {
        new Param('parameter', 'wrongType', true, true);
    }
}
