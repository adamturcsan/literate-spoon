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

namespace LegoW\LiterateSpoon\Test;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\ParamBuilder;
use LegoW\LiterateSpoon\Param;

/**
 * Description of ParamBuilderTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ParamBuilderTest extends TestCase
{
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Component type
     */
    public function testCreateWithNonExistantComponentType()
    {
        $builder = new ParamBuilder();
        
        $builder->create('test', 'fakeType', true, true);
    }
    
    public function testCreate()
    {
        $builder = new ParamBuilder();
        
        $param = $builder->create('test', 'columns', true, true);
        $this->assertInstanceOf(Param::class, $param);
        $this->assertTrue($param->isMultiple());
        $this->assertTrue($param->isOptional());
        $this->assertSame($param->getName(), 'test');
        
        $param2 = $builder->create('test', 'literal', false, false);
        $this->assertFalse($param2->isMultiple());
        $this->assertFalse($param2->isOptional());
        $this->assertSame('test', $param2->getName());
    }
    
    public function testCreateFromFormat()
    {
        $builder = new ParamBuilder();
        
        $params = $builder->createFromFormat(
            ':mandatory-literal and [:optional-table_name]+ and [:not_optional-literal'
        );
        $this->assertTrue(is_array($params));
        foreach($params as $param) {
            $this->assertInstanceOf(Param::class, $param);
            switch($param->getName()) {
                case ':mandatory-literal':
                    $this->assertFalse($param->isOptional());
                    $this->assertFalse($param->isMultiple());
                    break;
                case '[:optional-table_name]+': 
                    $this->assertTrue($param->isOptional());
                    $this->assertTrue($param->isMultiple());
                    break;
                case '[:not_optional-literal':
                    $this->assertFalse($param->isOptional());
                    $this->assertFalse($param->isMultiple());
                    break;
            }
        }
    }
}
