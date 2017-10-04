<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Literal;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Literal\StringLiteral;

/**
 * Description of StringLiteralTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class StringLiteralTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $stringLiteral = new StringLiteral('testText');
        $this->assertSame('"testText"', (string)$stringLiteral);
    }
}
