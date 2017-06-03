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

namespace LegoW\LiterateSpoon;

/**
 * Description of ParamBuilder
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class ParamBuilder
{
    /**
     * @param string $name
     * @param string $type
     * @param bool $isOptional
     * @param bool $isMultiple
     * @return \LegoW\LiterateSpoon\Param
     */
    public function create($name, $type, $isOptional, $isMultiple)
    {
        return new Param($name, $type, $isOptional, $isMultiple);
    }
    
    /**
     * @param string $format
     * @return Param[]
     */
    public function createFromFormat($format) {
        $matches = null;
        preg_match_all('/(?<optional1>\[)?:(?<name>[a-zA-Z][a-zA-Z0-9_]*)-(?<type>[a-zA-Z_]+)(?<optional2>\])?(?<isMultiple>\+)?/',
                $format, $matches);
        $params = [];
        foreach ($matches[0] as $key => $param) {
            $name = $matches['name'][$key];
            $type = $matches['type'][$key];
            $isMultiple = $matches['isMultiple'][$key] === '+';
            $isOptional = $matches['optional1'][$key] === '[' && $matches['optional2'][$key] === ']';
            $params[$name] = $this->create($param, $type,
                    $isOptional, $isMultiple);
        }
        return $params;
    }
}
