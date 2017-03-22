<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Column;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Column\Custom;

/**
 * Description of Custom
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class CustomTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $customColumn = new Custom('test');
        $this->assertSame('test', (string)$customColumn);
    }
    
    public function testSetValue()
    {
        $customColumn = new Custom();
        $this->assertSame('', (string)$customColumn);
        $svCustomColumn = $customColumn->setValue('test');
        $this->assertSame('test', (string)$customColumn);
        $this->assertSame($customColumn, $svCustomColumn, 'Test if it returns itself');
    }
    
}
