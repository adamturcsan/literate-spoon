<?php

/*
 * All rights reserved © 2017 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component;

use LegoW\LiterateSpoon\Component\Select;
use LegoW\LiterateSpoon\Component\Union;
use PHPUnit\Framework\TestCase;
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
        
        $select = new Select();
        $union->addSelect($select);
        
        $this->assertSame((string)$select, (string)$union);
        
        $unionAfter = $union->addSelect($select);
        $this->assertSame((string)$select.' UNION '.(string)$select, (string)$union);
        $this->assertSame($union, $unionAfter);
    }

    public function testAddNewSelect()
    {
        $union = new Union();

        $select = $union->addNewSelect();
        $this->assertInstanceOf(Select::class, $select);
        $this->assertSame((string)$select, (string)$union);

        $select2 = $union->addNewSelect('testTable');
        $this->assertSame((string)$select.' UNION '.(string)$select2, (string)$union);
        $select->setTableName('testTableFirst');
        $this->assertSame((string)$select.' UNION '.(string)$select2, (string)$union);
    }
}
