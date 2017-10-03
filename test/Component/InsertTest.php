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

use LegoW\LiterateSpoon\Component\Insert;
use LegoW\LiterateSpoon\Component\InsertColumns;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;
use LegoW\LiterateSpoon\Param;
use PHPUnit\Framework\TestCase;

/**
 * Description of InsertTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class InsertTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $insert = new Insert();
        $this->assertSame('INSERT INTO :' . Insert::PARAM_NAME_TABLE . '-table_name VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);
    }

    public function testSetTableName()
    {
        $insert = new Insert();
        $stnInsert = $insert->setTableName('test');
        $this->assertSame('INSERT INTO test VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);
        $this->assertSame($insert, $stnInsert, 'Test if it returns itself');
    }

    /**
     * @depends testSetTableName
     */
    public function testTableNameConstructor()
    {
        $insert = new Insert('test');
        $this->assertSame('INSERT INTO test VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);
    }

    public function testOptionalParameter()
    {
        $insert = new Insert('test');
        $insert->setParam(Insert::PARAM_NAME_COLUMNS,
                new InsertColumns(['test', 'test2']));
        $this->assertSame('INSERT INTO test (`test`, `test2`) VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);
    }

    public function testValuesParameter()
    {
        $insert = new Insert('test');
        $insert->setParam(Insert::PARAM_NAME_VALUES, new Placeholder('value'));
        $this->assertSame('INSERT INTO test VALUES (:value)', (string) $insert);
    }

    public function testAddColumn()
    {
        $insert = new Insert('test');
        $acInsert = $insert->addColumn('test');
        $this->assertSame('INSERT INTO test (`test`) VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);

        $this->assertSame($insert, $acInsert, 'Test if it returns itself');
    }

    public function testAddColumnMultipleTimes()
    {
        $insert = new Insert('test');
        $ac1Insert = $insert->addColumn('test1');
        $ac2Insert = $insert->addColumn('test2');
        $this->assertSame('INSERT INTO test (`test1`, `test2`) VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);
        $this->assertSame($insert, $ac1Insert);
        $this->assertSame($insert, $ac2Insert);
    }

    public function testColumns()
    {
        $insert = new Insert('test');
        $acInsert = $insert->addColumns(['test1', 'test2']);
        $this->assertSame('INSERT INTO test (`test1`, `test2`) VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',
                (string) $insert);

        $this->assertSame($insert, $acInsert, 'Test if it returns itself');
    }

    public function testAddValuePlaceHolderFor()
    {
        $insert = new Insert('test');
        $aphInsert = $insert->addValuePlaceHolderFor('value');
        $this->assertSame('INSERT INTO test VALUES (:value)', (string) $insert);

        $this->assertSame($insert, $aphInsert, 'Test if it returns itself');
    }

    /**
     * @covers \LegoW\LiterateSpoon\Component\AbstractComponent::getParam
     */
    public function testGetParam()
    {
        $insert = new Insert('test');
        $param = $insert->getParam(Insert::PARAM_NAME_TABLE);
        $this->assertInstanceOf(Param::class, $param);
        $this->assertEquals('test',$param->getValue());
    }

    /**
     * @covers \LegoW\LiterateSpoon\Component\AbstractComponent::getParam
     */
    public function testGetNullParam()
    {
        $insert = new Insert();
        $param = $insert->getParam('wrong_name');
        $this->assertNull($param);
    }
}
