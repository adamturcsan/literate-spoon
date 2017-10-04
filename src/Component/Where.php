<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Component\Traits\ConditionAwareTrait;

/**
 * Description of Where
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Where extends AbstractComponent implements ConditionAwareInterface
{
    use ConditionAwareTrait;

    public function getFormat()
    {
        return 'WHERE :'.self::PARAM_NAME_CONDITIONS.'-condition+';
    }

    public function __construct($operator = self::OP_AND)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setOperator($operator);
    }
}
