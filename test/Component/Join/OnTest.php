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

use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Join\On;
use PHPUnit\Framework\TestCase;

/**
 * Description of OnTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class OnTest extends TestCase
{
    public function testConstructionWithoutCondition()
    {
        $on = new On();
        $this->assertInstanceOf(On::class, $on);
        $this->assertSame('ON :'.On::PARAM_NAME_CONDITIONS.'-condition', (string)$on);
    }

    public function testConstructionWithCondition()
    {
        $on = new On($this->createMock(Condition::class));
        $this->assertInstanceOf(On::class, $on);
        $this->assertSame('ON ', (string)$on);
    }
}
