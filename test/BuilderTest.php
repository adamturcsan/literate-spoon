<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Builder;
use LegoW\LiterateSpoon\Component\Select;
use LegoW\LiterateSpoon\Component\Columns;
use LegoW\LiterateSpoon\Component\TableName;
use LegoW\LiterateSpoon\Component\Where;
use LegoW\LiterateSpoon\Component\Literal\StringLiteral;
use LegoW\LiterateSpoon\Component\Literal\IntLiteral;
use LegoW\LiterateSpoon\Component\Condition\Compare;
use LegoW\LiterateSpoon\Component\Condition\Group;

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
        $builder->addComponent($component);
        $this->assertAttributeEquals([$component], 'components', $builder);
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

    public function testWhere()
    {

        $where = new Where(Where::OP_OR);
        $where->compare('=', new Columns(['test-column']),
                new StringLiteral('test-value'));
        $where->compare('>', new Columns(['second-test']),
                new StringLiteral('second-value'));

        $group = new Group();
        $group->addCondition(new Compare('=', new Columns(['test']),
                        new StringLiteral('value')))
                ->addCondition(new Compare('=', new Columns(['test2']),
                        new StringLiteral('value2')));
        $where->addCondition($group);

        $select = new Select();
        $select->setTableName('test')
                ->setChild('WHERE', $where);
        $builder = new Builder([$select]);

        $expectedString = 'SELECT * FROM test WHERE (`test-column` = "test-value") OR (`second-test` > "second-value") OR ((`test` = "value") AND (`test2` = "value2"));';

        $this->assertEquals($expectedString, $builder->asString());
    }
    
    public function testInsert()
    {
        $insert = new Component\Insert('test');
        
        $insertColumns = new Component\InsertColumns(['test-column', 'test-column2']);
        $insert->setParam('columns', $insertColumns);
        $insert->setParam('value', new StringLiteral('valami'));
        $insert->setParam('value', new IntLiteral(5));
        
        $builder = new Builder([$insert]);
        
        $expectedString = 'INSERT INTO test (`test-column`, `test-column2`) VALUES ("valami", 5);';
        
        $this->assertEquals($expectedString, $builder->asString());
    }

}
