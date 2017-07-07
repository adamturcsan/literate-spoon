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
use LegoW\LiterateSpoon\Component\TableName;

/**
 * Description of TableNameTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class TableNameTest extends TestCase
{
    
    /**
     * Should throw error because name argument must be set
     * It was taken into account, that on different PHP versions different kind
     * of exceptions are thrown
     */
    public function testDefaultConstructor()
    {
        if(class_exists('\ArgumentCountError')) {
            try {
                new TableName();
            } catch (\ArgumentCountError $ex) {
                return; //TEST OK
            }
        }
        try {
            new TableName();
        } catch (\PHPUnit_Framework_Error $ex) {
            return; //TEST OK
        }
    }
    
    public function testConstructorWithName()
    {
        $tableName = new TableName('table');
        $this->assertSame('table', (string)$tableName);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithNotStringParameter()
    {
        new TableName([]);
    }
    
}
