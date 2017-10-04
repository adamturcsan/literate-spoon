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

namespace LegoW\LiterateSpoon\Component\Literal;

use LegoW\LiterateSpoon\Component\Literal;

/**
 * Description of ExpressionLiteral
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ExpressionLiteral extends Literal
{
    /**
     * @var string
     */
    protected $format;

    public function getFormat()
    {
        return $this->format;
    }

    public function __construct($expression)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->format = $expression;
    }
}
