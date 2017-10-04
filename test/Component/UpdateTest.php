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
use LegoW\LiterateSpoon\Component\Update;
use LegoW\LiterateSpoon\Component\SetColumn;

/**
 * Description of UpdateTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class UpdateTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $update = new Update();
        $this->assertSame('UPDATE :table-table_name SET :column-set_column+', (string)$update);
    }

    public function testSetTableName()
    {
        $update = new Update();
        $update->setTableName('test_table');
        $this->assertSame('UPDATE test_table SET :column-set_column+', (string)$update);
    }

    public function testTableNameConstructor()
    {
        $update = new Update('test_table');
        $this->assertSame('UPDATE test_table SET :column-set_column+', (string)$update);
    }

    /**
     * @depends testTableNameConstructor
     */
    public function testAddSetColumn()
    {
        $update = new Update('test_table');
        $setColumn = new SetColumn('columnName');
        $setColumn->setValueParamName('value');
        $update->addSetColumn($setColumn);
        $this->assertSame('UPDATE test_table SET `columnName` = :value', (string)$update);
        $setColumn2 = new SetColumn('newColumn');
        $setColumn2->setValueParamName('newValue');
        $update->addSetColumn($setColumn2);
        $this->assertSame('UPDATE test_table SET `columnName` = :value, `newColumn` = :newValue', (string)$update);
    }

    /**
     * @depends testAddSetColumn
     */
    public function testSet()
    {
        $update = new Update('test_table');
        $update->set('columnName', 'value')
               ->set('newColumn', 'newValue')
               ->set('newestColumn', 'newestValue');
        $query = 'UPDATE test_table SET `columnName` = :value, `newColumn` = :newValue, `newestColumn` = :newestValue';
        $this->assertSame($query, (string)$update);
    }
}
