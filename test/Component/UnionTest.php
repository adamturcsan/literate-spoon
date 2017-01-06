<?php

/*
 * All rights reserved © 2017 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Union;
/**
 * Description of UnionTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 * @coversDefaultClass LegoW\LiterateSpoon\Component\Union
 */
class UnionTest extends TestCase
{
    /**
     * @covers ::__construct()
     */
    public function testDefaultConstructor()
    {
        $union = new Union();
        $this->assertSame(':select-select+', (string)$union);
    }
    
    public function testAddSelect()
    {
        $union= new Union();
        
        $select = new \LegoW\LiterateSpoon\Component\Select();
        $union->addSelect($select);
        
        $this->assertSame((string)$select, (string)$union);
        
        $union->addSelect($select);
        $this->assertSame((string)$select.' UNION '.(string)$select, (string)$union);
    }
}
