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

declare (strict_types = 1);

namespace LegoW\LiterateSpoon\Component\Condition;

use LegoW\LiterateSpoon\Component\Column;
use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\Literal;
use LegoW\LiterateSpoon\Component\Literal\Placeholder;

/**
 * Description of In
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class In extends Condition
{
    const PARAM_NAME_COLUMN = 'column';
    const PARAM_NAME_ELEMENT = 'element';

    public function getFormat()
    {
        return ' :column-column IN (:' . self::PARAM_NAME_ELEMENT . '-literal+)';
    }

    public function __construct($columnName = null, array $elementSet = null)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setColumnName($columnName);
        $this->addElements($elementSet);
    }

    public function setColumnName($columnName = null)
    {
        if ($columnName === null) {
            return $this;
        }
        $column = new Column($columnName);
        $this->setParam(self::PARAM_NAME_COLUMN, $column);
        return $this;
    }

    public function addElements(array $elementSet = null)
    {
        if ($elementSet === null) {
            return $this;
        }
        foreach ($elementSet as $element) {
            $this->addElement($element);
        }
        return $this;
    }

    public function addElement(Literal $element)
    {
        $this->setParam(self::PARAM_NAME_ELEMENT, $element);
        return $this;
    }

    public function addElementPlaceholder($name)
    {
        $placeHolder = new Placeholder($name);
        return $this->addElement($placeHolder);
    }
}
