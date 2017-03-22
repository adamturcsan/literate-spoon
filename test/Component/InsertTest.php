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

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Insert;
use LegoW\LiterateSpoon\Component\InsertColumns;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

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
        $this->assertSame('INSERT INTO test (`test`, `test2`) VALUES (:' . Insert::PARAM_NAME_VALUES . '-literal+)',(string)$insert);
    }

    public function testValuesParameter()
    {
        $insert = new Insert('test');
        $insert->setParam(Insert::PARAM_NAME_VALUES, new Placeholder('value'));
    }
}
