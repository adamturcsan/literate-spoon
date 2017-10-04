<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component\Condition;

use LegoW\LiterateSpoon\Component\Condition;
use LegoW\LiterateSpoon\Component\ConditionAwareInterface;
use LegoW\LiterateSpoon\Component\Traits\ConditionAwareTrait;

/**
 * Description of SubWhere
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Group extends Condition implements ConditionAwareInterface
{
    use ConditionAwareTrait;

    public function getFormat()
    {
        return '(:' . self::PARAM_NAME_CONDITIONS . '-condition+)';
    }

    public function __construct($operator = self::OP_AND)
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setOperator($operator);
    }
}
