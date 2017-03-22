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

use LegoW\LiterateSpoon\Component\AbstractComponent;
use LegoW\LiterateSpoon\Component\Literal\IntLiteral;

/**
 * Description of Limit
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Limit extends AbstractComponent
{

    const PARAM_NAME_OFFSET = 'offset';
    const PARAM_NAME_NUM = 'num';

    protected $format = 'LIMIT :offset-literal, :num-literal';

    public function getFormat()
    {
        return $this->format;
    }

    public function __construct($num = 1, $offset = 0)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setLimit($num, $offset);
    }

    public function setLimit($num, $offset = 0)
    {
        $numLiteral = new IntLiteral($num);
        $offsetLiteral = new IntLiteral($offset);

        return $this->setNum($numLiteral)
                        ->setOffset($offsetLiteral);
    }

    public function setNum(IntLiteral $num)
    {
        $this->setParam(self::PARAM_NAME_NUM, $num);
        return $this;
    }

    public function setOffset(IntLiteral $offset)
    {
        $this->setParam(self::PARAM_NAME_OFFSET, $offset);
        return $this;
    }

}
