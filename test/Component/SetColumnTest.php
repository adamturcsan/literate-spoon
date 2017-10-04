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
use LegoW\LiterateSpoon\Component\SetColumn;
use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

/**
 * Description of SetColumnTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class SetColumnTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $setColumn = new SetColumn();
        $this->assertSame(':column-column = :value-literal', (string)$setColumn);
    }

    public function testSetColumn()
    {
        $setColumn = new SetColumn();
        $column = new Column('name');
        $setColumnAfter = $setColumn->setColumn($column);
        $this->assertSame('`name` = :value-literal', (string)$setColumn);
        $this->assertSame($setColumn, $setColumnAfter);
    }

    public function testSetColumnName()
    {
        $setColumn = new SetColumn();
        $setColumn->setColumnName('name');
        $this->assertSame('`name` = :value-literal', (string)$setColumn);
    }

    public function testColumnNameConstructor()
    {
        $setColumn = new SetColumn('name');
        $this->assertSame('`name` = :value-literal', (string)$setColumn);
    }

    /**
     * @depends testColumnNameConstructor
     */
    public function testSetValue()
    {
        $setColumn = new SetColumn('name');
        $value = new Placeholder('value');
        $setColumnAfter = $setColumn->setValue($value);
        $this->assertSame('`name` = :value', (string)$setColumn);
        $this->assertSame($setColumn, $setColumnAfter);
    }

    /**
     * @depends testColumnNameConstructor
     */
    public function testSetValueParamName()
    {
        $setColumn = new SetColumn('name');
        $setColumn->setValueParamName('value');
        $this->assertSame('`name` = :value', (string)$setColumn);
    }
}
