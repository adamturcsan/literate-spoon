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
use LegoW\LiterateSpoon\Component\Literal\IntLiteral;
use LegoW\LiterateSpoon\Component\Limit;

/**
 * Description of LimitTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class LimitTest extends TestCase
{
    public function testDefaultConsturctor()
    {
        $limit = new Limit();
        $this->assertSame('LIMIT 0, 1', (string)$limit);
    }

    public function testNumConstructor()
    {
        $limit = new Limit(100);
        $this->assertSame('LIMIT 0, 100', (string)$limit);
    }

    public function testNumAndOffsetConstructor()
    {
        $limit = new Limit(100, 1000);
        $this->assertSame('LIMIT 1000, 100', (string)$limit);
    }
    
    public function testSetLimit()
    {
        $limit = new Limit();
        $limit->setLimit(123, 456);
        $this->assertSame('LIMIT 456, 123', (string)$limit);
        $limit->setLimit(234, 567);
        $this->assertSame('LIMIT 567, 234', (string)$limit);
    }
    
    public function testSetNum()
    {
        $limit = new Limit();
        $intLiteral = new IntLiteral(234);
        $limit->setNum($intLiteral);
        $this->assertSame('LIMIT 0, 234', (string)$limit);
        $intLiteral2 = new IntLiteral(321);
        $limit->setNum($intLiteral2);
        $this->assertSame('LIMIT 0, 321', (string)$limit);
    }
    
    public function testSetOffset()
    {
        $limit = new Limit();
        $intLiteral = new IntLiteral(234);
        $afterLimit = $limit->setOffset($intLiteral);
        $this->assertSame('LIMIT 234, 1', (string)$limit);
        $this->assertSame($limit, $afterLimit);
        $intLiteral2 = new IntLiteral(321);
        $afterLimit2 = $limit->setOffset($intLiteral2);
        $this->assertSame('LIMIT 321, 1', (string)$limit);
        $this->assertSame($limit, $afterLimit2);
        $this->assertSame($afterLimit, $afterLimit2);
    }
}
