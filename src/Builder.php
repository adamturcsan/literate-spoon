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
    private $queryString;

    /**
     * Holds the query components
     *
     * @var ComponentInterface[]|\Traversable
     */
    private $components;

    /**
     * Indicates whether query string is outdated
     *
     * @var bool
     */
    private $isStringOutdated = true;

    /**
     * @param ComponentInterface[]|\Traversable $components
     * @throws \InvalidArgumentException
     */
    public function __construct($components = [])
    {
        if ($components !== null && (! is_array($components) && ! $components instanceof \Traversable)) {
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
        if ($this->queryString === null || $this->isStringOutdated) {
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

    /**
     * Creates and returns a new Component\Select instance added to this Builder instance
     *
     * @param string $tableName
     * @param array $columns
     * @return \LegoW\LiterateSpoon\Component\Select
     */
    public function select($tableName = null, array $columns = null)
    {
        $select = new Component\Select($tableName, $columns);
        $this->addComponent($select);
        return $select;
    }

    /**
     * Creates and returns a new Component\Insert instance added to this Builder instance
     *
     * @param string $tableName
     * @return \LegoW\LiterateSpoon\Component\Insert
     */
    public function insert($tableName = null)
    {
        $insert = new Component\Insert($tableName);
        $this->addComponent($insert);
        return $insert;
    }

    /**
     * Creates and returns a new Component\Union instance added to this Builder instance
     *
     * @return \LegoW\LiterateSpoon\Component\Union
     */
    public function union()
    {
        $union = new Component\Union();
        $this->addComponent($union);
        return $union;
    }

    /**
     * Creates and returns a new Component\Delete instance added to this Builder instance
     *
     * @param string $tableName
     * @return \LegoW\LiterateSpoon\Component\Delete
     */
    public function delete($tableName = null)
    {
        $delete = new Component\Delete($tableName);
        $this->addComponent($delete);
        return $delete;
    }

    /**
     * Creates and returns a new Component\Update instance added to this Builder instance
     *
     * @param string $tableName
     * @return \LegoW\LiterateSpoon\Component\Update
     */
    public function update($tableName = null)
    {
        $update = new Component\Update($tableName);
        $this->addComponent($update);
        return $update;
    }
}
