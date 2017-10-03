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
use LegoW\LiterateSpoon\Component\Delete;
use LegoW\LiterateSpoon\Component\TableName;

/**
 * Description of DeleteTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class DeleteTest extends TestCase
{
    public function testDefaultConstruct()
    {
        $delete = new Delete();
        $this->assertSame('DELETE FROM :table-table_name', (string)$delete);
    }
    
    public function testTableNameConstruct()
    {
        $delete = new Delete('tableName');
        $this->assertSame('DELETE FROM tableName', (string)$delete);
    }
    
    public function testSetTable()
    {
        $delete = new Delete();
        $this->assertSame('DELETE FROM :table-table_name', (string)$delete);
        $delete->setTableName('tableName');
        $this->assertSame('DELETE FROM tableName', (string)$delete);
    }
}
