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
 * Description of Direction
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Direction extends AbstractComponent
{
    const DESC = 'DESC';
    const ASC = 'ASC';
    
    protected $format;
    
    public function getFormat()
    {
        return $this->format;
    }
    
    public function __construct($direction = 'ASC')
    {
        $possibleChildren = [];
        parent::__construct($possibleChildren);
        $this->setDirection($direction);
    }
    
    public function setDirection($direction)
    {
        if($direction !== self::ASC && $direction !== self::DESC) {
            throw  new \InvalidArgumentException('Direction must be only \''.self::ASC.'\' or \''.self::DESC.'\'');
        }
        $this->format = $direction;
    }

}
