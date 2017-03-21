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
use LegoW\LiterateSpoon\Component\Replace;

/**
 * Description of ReplaceTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ReplaceTest extends TestCase
{
    
    public function testDefaultConstructor()
    {
        $replace = new Replace();
        $this->assertSame('REPLACE INTO :'.Replace::PARAM_NAME_TABLE.'-table_name VALUES (:'.Replace::PARAM_NAME_VALUES.'-literal+)', (string)$replace);
    }
    
}
