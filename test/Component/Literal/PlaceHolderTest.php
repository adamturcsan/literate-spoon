<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Literal;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

/**
 * Description of PlaceHolderTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class PlaceHolderTest extends TestCase
{

    public function testConstructorWithoutColon()
    {
        $placeHolderLiteral = new Placeholder('test-place');
        $this->assertSame(':test-place', (string) $placeHolderLiteral);
    }

    public function testConstructorWithColon()
    {
        $placeHolderLiteral = new Placeholder(':test-place2');
        $this->assertSame(':test-place2', (string) $placeHolderLiteral);
    }
}
