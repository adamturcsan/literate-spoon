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
use LegoW\LiterateSpoon\Builder;
use LegoW\LiterateSpoon\Component\Select;
use LegoW\LiterateSpoon\Component\Limit;
use LegoW\LiterateSpoon\Component\Columns;

/**
 * Description of IntegrationTest
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class IntegrationTest extends TestCase
{

    public function testComplexSelectWithLimit()
    {
        $select = new Select('test', ['test1', 'test2']);
        $select->limit(15, 10);
        $this->assertSame('SELECT `test1`, `test2` FROM test LIMIT 10, 15',
                (string) $select);
    }

    public function testBuilderWithMultipleComponent()
    {
        $builder = new Builder();

        $select = new Select('test', ['test1', 'test2']);
        $limit = new Limit(23, 10);

        $builder->addComponent($select);
        $builder->addComponent($limit);

        $this->assertSame('SELECT `test1`, `test2` FROM test LIMIT 10, 23;',
                $builder->asString());
    }

    public function testComplexInsertFromBuilder()
    {
        $builder = new Builder();

        $builder->insert('testTable')
                ->addColumn('columnOne')->addValuePlaceHolderFor('one')
                ->addColumn('columnTwo')->addValuePlaceHolderFor('two');

        $query = $builder->asString();
        $this->assertSame('INSERT INTO testTable (`columnOne`, `columnTwo`) VALUES (:one, :two);', $query);
    }
}
