<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Literal;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Literal\BooleanLiteral;

/**
 * Description of BooleanLiteralTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class BooleanLiteralTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $booleanTrue = new BooleanLiteral(true);
        $this->assertSame('true', (string) $booleanTrue);
        $booleanFalse = new BooleanLiteral(false);
        $this->assertSame('false', (string) $booleanFalse);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongParamConstruct()
    {
        new BooleanLiteral('true');
    }

}
