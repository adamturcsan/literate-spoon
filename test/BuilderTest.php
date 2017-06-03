<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Builder;
use LegoW\LiterateSpoon\Component\Select;
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\TableName;

/**
 * Description of BuilderTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 * @coversDefaultClass LegoW\LiterateSpoon\Builder
 */
class BuilderTest extends TestCase
{

    /**
     * @covers ::__construct
     */
    public function testEmptyConstructor()
    {
        $builder = new Builder();
        $this->assertInstanceOf(Builder::class, $builder);
    }

    /**
     * @covers ::__construct
     */
    public function testComponentsConstructor()
    {
        $components = [new Select()];
        $builder = new Builder($components);
        $this->assertInstanceOf(Builder::class, $builder);
        $this->assertAttributeEquals($components, 'components', $builder);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers ::__construct
     */
    public function testConstructorNonTraversable()
    {
        $wrongComponents = 1;
        new Builder($wrongComponents);
    }

    /**
     * @covers ::addComponent
     */
    public function testAddComponent()
    {
        $component = new Select();
        $builder = new Builder();
        $acBuilder = $builder->addComponent($component);
        $this->assertAttributeEquals([$component], 'components', $builder);

        $this->assertSame($builder, $acBuilder, 'Test if it returns itself');

        return $builder;
    }

    /**
     * @depends testAddComponent
     * @covers ::asString
     * @param Builder $builder 
     */
    public function testAsStringWithoutParams(Builder $builder)
    {
        $queryString = $builder->asString();
        $expectedString = 'SELECT * FROM :table-table_name;';
        $this->assertEquals($expectedString, $queryString);
    }

    public function testAsString()
    {
        $builder = new Builder();

        $columns = new Columns();
        $table = new TableName('test');

        $select = new Select();
        $select->setParam('columns', $columns)
                ->setParam('table', $table);

        $builder->addComponent($select);

        $queryString = $builder->asString();
        $expectedString = 'SELECT * FROM test;';

        $this->assertEquals($expectedString, $queryString);
    }

}
