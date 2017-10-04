<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Literal;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Literal\IntLiteral;

/**
 * Description of IntLiteralTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class IntLiteralTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $intLiteral = new IntLiteral(1);
        $this->assertSame('1', (string) $intLiteral);
    }
}
