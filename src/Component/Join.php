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

use InvalidArgumentException;
use LegoW\LiterateSpoon\Component\Join\On;
use LegoW\LiterateSpoon\Component\Join\Using;
use LegoW\LiterateSpoon\Component\Literal\ExpressionLiteral;
use LegoW\LiterateSpoon\Component\Traits\TableNameAwareTrait;

/**
 * Description of Join
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Join extends AbstractComponent implements TableNameAwareInterface
{
    use TableNameAwareTrait;

    const TYPE_LEFT = 'LEFT';
    const TYPE_INNER = 'INNER';
    const TYPE_RIGHT = 'RIGHT';
    const TYPE_OUTER = 'OUTER';
    const CHILD_ON = 'ON';
    const CHILD_USING = 'USING';
    const PARAM_NAME_TYPE = 'type';

    private $possibleTypes = [
        self::TYPE_INNER,
        self::TYPE_LEFT,
        self::TYPE_OUTER,
        self::TYPE_RIGHT
    ];

    public function __construct($tableName = null, $type = null)
    {
        $possibleChildren = [self::CHILD_ON, self::CHILD_USING];
        parent::__construct($possibleChildren);
        if ($tableName !== null) {
            $this->setTableName($tableName);
        }
        if ($type !== null) {
            $this->setType($type);
        }
    }

    public function getFormat()
    {
        return ' [:' . self::PARAM_NAME_TYPE . '-literal] JOIN :' . self::PARAM_NAME_TABLE . '-table_name';
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        if (! in_array($type, $this->possibleTypes)) {
            throw new InvalidArgumentException('Non-valid type has been given');
        }
        $typeLiteral = new ExpressionLiteral($type);
        $this->setParam(self::PARAM_NAME_TYPE, $typeLiteral);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setChild($name, ComponentInterface $component)
    {
        if ($name == self::CHILD_ON && $this->hasChild(self::CHILD_USING)) {
            throw new \InvalidArgumentException('Only one should be used from ON or USING');
        }
        if ($name == self::CHILD_USING && $this->hasChild(self::CHILD_ON)) {
            throw new \InvalidArgumentException('Only one should be used from ON or USING');
        }
        return parent::setChild($name, $component);
    }

    public function on(Condition $condition = null)
    {
        if ($this->hasChild(self::CHILD_ON)) {
            return $this->getChild(self::CHILD_ON);
        }
        $on = new On($condition);
        $this->setChild(self::CHILD_ON, $on);
        return $on;
    }

    public function using($columnName = null)
    {
        if ($this->hasChild(self::CHILD_USING)) {
            return $this->getChild(self::CHILD_USING);
        }
        $using = new Using($columnName);
        $this->setChild(self::CHILD_USING, $using);
        return $using;
    }
}
