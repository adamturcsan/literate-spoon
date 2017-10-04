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

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Component\WhereableInterface;
use LegoW\LiterateSpoon\Component\Traits\WhereableTrait;
use LegoW\LiterateSpoon\Component\Traits\TableNameAwareTrait;

/**
 * Description of Delete
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Delete extends AbstractComponent implements WhereableInterface, TableNameAwareInterface
{
    use WhereableTrait;
    use TableNameAwareTrait;

    const CHILD_LIMIT = 'LIMIT';

    public function getFormat()
    {
        return 'DELETE FROM :'.self::PARAM_NAME_TABLE.'-table_name';
    }

    public function __construct($table = null)
    {
        $possibleChildren = [self::CHILD_WHERE, self::CHILD_LIMIT];
        parent::__construct($possibleChildren);
        if ($table !== null) {
            $this->setTableName($table);
        }
    }
}
