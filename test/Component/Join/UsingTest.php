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

namespace LegoW\LiterateSpoon\Test\Component\Join;

use LegoW\LiterateSpoon\Component\Join\Using;
use PHPUnit\Framework\TestCase;

/**
 * Description of Using
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class UsingTest extends TestCase
{
    public function testConstructionWithoutColumnName()
    {
        $using = new Using();
        $this->assertInstanceOf(Using::class, $using);
        $this->assertSame('USING :'.Using::PARAM_NAME_COLUMN_NAME.'-column', (string)$using);
    }

    public function testSetColumnName()
    {
        $using = new Using();
        $this->assertSame('USING :'.Using::PARAM_NAME_COLUMN_NAME.'-column', (string)$using);
        $using->setColumnName('test');
        $this->assertSame('USING `test`', (string)$using);
    }

    public function testConstructionWithColumnName()
    {
        $using = new Using('test');
        $this->assertInstanceOf(Using::class, $using);
        $this->assertSame('USING `test`', (string)$using);
    }
}
