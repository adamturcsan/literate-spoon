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
use LegoW\LiterateSpoon\Component\Direction;

/**
 * Description of DirectionTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class DirectionTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $direction = new Direction();
        $this->assertEquals('ASC', (string)$direction);
    }

    public function testConstructorWithDirection()
    {
        $direction = new Direction('DESC');
        $this->assertEquals('DESC', (string)$direction);
        return $direction;
    }

    /**
     * @depends testConstructorWithDirection
     * @param Direction $direction
     */
    public function testSetDirection(Direction $direction)
    {
        $direction->setDirection(Direction::ASC);
        $this->assertEquals(Direction::ASC, (string)$direction);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Direction must be
     */
    public function testWrongDirection()
    {
        $direction = new Direction('wrong');
    }
}
