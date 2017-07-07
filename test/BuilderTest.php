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
use LegoW\LiterateSpoon\Component\Insert;
use LegoW\LiterateSpoon\Component\Union;
use LegoW\LiterateSpoon\Component\Delete;
use LegoW\LiterateSpoon\Component\Update;

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

    /**
     * @covers ::select
     */
    public function testFluentEmptySelect()
    {
        $builder = new Builder();

        $selectString = (string) (new Select());
        $fluentSelect = $builder->select();

        $this->assertSame($selectString, (string) $fluentSelect);
        $this->assertSame($selectString . ';', $builder->asString());
    }

    /**
     * @covers ::select
     */
    public function testFluentTableSelect()
    {
        $builder = new Builder();

        $selectString = (string) (new Select('tableName'));
        $fluentSelect = $builder->select('tableName');
        $this->assertSame($selectString, (string) $fluentSelect);
        $this->assertSame($selectString . ';', $builder->asString());
    }

    /**
     * @covers ::select
     */
    public function testFluentTableAndColumnSelect()
    {
        $builder = new Builder();

        $selectString = (string) (new Select('tableName', ['column1', 'column2']));
        $fluentSelect = $builder->select('tableName', ['column1', 'column2']);
        $this->assertSame($selectString, (string) $fluentSelect);
        $this->assertSame($selectString . ';', $builder->asString());
    }

    /**
     * @covers ::insert
     */
    public function testFluentEmptyInsert()
    {
        $builder = new Builder();

        $insertString = (string) (new Insert());
        $fluentInsert = $builder->insert();

        $this->assertSame($insertString, (string) $fluentInsert);
        $this->assertSame($insertString . ';', $builder->asString());
    }

    /**
     * @covers ::insert
     */
    public function testFluentTableInsert()
    {
        $builder = new Builder();

        $insertString = (string) (new Insert('tableName'));
        $fluentInsert = $builder->insert('tableName');

        $this->assertSame($insertString, (string) $fluentInsert);
        $this->assertSame($insertString . ';', $builder->asString());
    }

    /**
     * @covers ::union
     */
    public function testFluentUnion()
    {
        $builder = new Builder();

        $unionString = (string) (new Union());
        $fluentUnion = $builder->union();

        $this->assertSame($unionString, (string) $fluentUnion);
        $this->assertSame($unionString . ';', $builder->asString());
    }

    /**
     * @covers ::delete
     */
    public function testFluentEmptyDelete()
    {
        $builder = new Builder();

        $deleteString = (string) (new Delete());
        $fluentDelete = $builder->delete();

        $this->assertSame($deleteString, (string) $fluentDelete);
        $this->assertSame($deleteString . ';', $builder->asString());
    }

    /**
     * @covers ::delete
     */
    public function testFluentTableDelete()
    {
        $builder = new Builder();

        $deleteString = (string) (new Delete('tableName'));
        $fluentDelete = $builder->delete('tableName');

        $this->assertSame($deleteString, (string) $fluentDelete);
        $this->assertSame($deleteString . ';', $builder->asString());
    }

    public function testFluentEmptyUpdate()
    {
        $builder = new Builder();

        $updateString = (string) (new Update());
        $fluentUpdate = $builder->update();

        $this->assertSame($updateString, (string) $fluentUpdate);
        $this->assertSame($updateString . ';', $builder->asString());
    }
    
    public function testFluentTableUpdate()
    {
        $builder = new Builder();
        
        $updateString = (string) (new Update('tableName'));
        $fluentUpdate = $builder->update('tableName');
        
        $this->assertSame($updateString, (string) $fluentUpdate);
        $this->assertSame($updateString . ';', $builder->asString());
    }

}
