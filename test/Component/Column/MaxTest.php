<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Column;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Column\Max;

/**
 * Description of MaxText
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class MaxTest extends TestCase
{

    public function testEmptyConstructor()
    {
        $maxColumn = new Max();
        $this->assertSame('MAX(:column-columns)', (string) $maxColumn);
    }

    public function testNonEmptyConstructor()
    {
        $maxColumn = new Max(['test']);
        $this->assertSame('MAX(`test`)', (string)$maxColumn);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWronArgumentConstructor()
    {
        $maxColumn = new Max(['test', 'test2']);
    }
}
