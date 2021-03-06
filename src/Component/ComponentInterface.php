<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon\Component;

use LegoW\LiterateSpoon\Param;

/**
 * Description of Component
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
interface ComponentInterface
{

    /**
     * Format string gives the actual query string format with named parameters
     *
     * @return string
     */
    public function getFormat();

    /**
     * @return Param[]
     */
    public function getParams();

    /**
     * @param string $name
     * @return Param|null
     */
    public function getParam($name);

    /**
     * @param string $name
     * @param ComponentInterface $value
     */
    public function setParam($name, ComponentInterface $value);

    /**
     * @return array
     */
    public function getChildren();

    /**
     *
     * @param string $name
     * @param ComponentInterface $component
     */
    public function setChild($name, ComponentInterface $component);

    /**
     * @return string
     */
    public function __toString();
}
