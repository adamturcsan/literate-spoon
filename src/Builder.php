<?php

/*
 * All rights reserved © 2016 Legow Hosting Kft.
 */

namespace LegoW\LiterateSpoon;

use LegoW\LiterateSpoon\Component\ComponentInterface;

/**
 * Description of Builder
 *
 * @author Turcsán Ádám <turcsan.adam@legow.hu>
 */
class Builder
{

    /**
     * Holds builded query string
     * 
     * @var string
     */
    protected $queryString;

    /**
     * Holds the query components
     * 
     * @var Components[]|\Traversable
     */
    protected $components;

    /**
     * Indicates whether query string is outdated
     * 
     * @var bool
     */
    protected $isStringOutdated = true;
    
    /**
     * @param Components[]|\Traversable $components
     * @throws \InvalidArgumentException
     */
    public function __construct($components = null)
    {
        if ( $components != null && (!is_array($components) && !$components instanceof \Traversable)) {
            throw new \InvalidArgumentException('$components argument should be iterable');
        }
        $this->components = $components;
    }

    /**
     * Returns the query string
     * @return string
     */
    public function asString()
    {
        if ($this->queryString == null || $this->isStringOutdated) {
            $this->queryString = trim(implode(' ', $this->components)).';';
            $this->isStringOutdated = false;
        }
        return $this->queryString;
    }
    
    /**
     * @param ComponentInterface $component
     * @returns $this
     */
    public function addComponent(ComponentInterface $component)
    {
        $this->isStringOutdated = true;
        $this->components[] = $component;
        return $this;
    }

}
