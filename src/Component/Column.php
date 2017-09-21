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

/**
 * Description of Column
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Column extends Columns
{
    protected $format = '*';

    /**
     * {@inheritDoc}
     */
    public function getFormat()
    {
        return $this->format;
    }

    public function __construct($name = null)
    {
        parent::__construct();
        if ($name !== null) {
            $this->setName($name);
        }
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->format = '`'.$name.'`';
        return $this;
    }
}
