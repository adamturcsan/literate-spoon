<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Test\Component\Literal;

use PHPUnit\Framework\TestCase;
use LegoW\LiterateSpoon\Component\Literal\ColumnLiteral;

/**
 * Description of ColumnLiteralTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ColumnLiteralTest extends TestCase
{

    public function testDefaultConstructor()
    {
        $columnLiteral = new ColumnLiteral('test');
        $this->assertSame('`test`', (string) $columnLiteral);
    }

}
