<?php

namespace Schematics;

abstract class Schematic
{
    protected $overrides = [];

    public function __construct($overrides = [])
    {
        $this->overrides = $overrides;
    }

    abstract public function map();

    public function schemas()
    {
        return [

        ];
    }

    public function readMap()
    {
        return array_merge($this->map(), $this->overrides);
    }

    protected static function bind($override = [])
    {
        $class = get_called_class();
        return new $class($override);
    }

    public function getSchema($name)
    {
        $class = $this->schemas()[$name];
        return new $class();
    }

    public function findName($keys)
    {
        $keys = (!is_array($keys)) ? [$keys] : $keys;
        return array_search(implode("|", $keys), $this->map());
    }

    public function findPath($name)
    {
        return (!empty($this->map()[$name])) ? $this->map()[$name] : null;
    }

    public function findKeys($name)
    {
        return explode("|", $this->findPath($name));
    }

    /**
     * Returns whether or not a particular item has a schema available
     *
     * @param $name
     * @return bool
     */
    public function itemHasSchema($name)
    {
        if (!empty($this->map()[$name])) {
            return (in_array($name, array_keys($this->schemas())));
        }
        return false;
    }

    public function itemExists($name)
    {
        return (in_array($name, array_keys($this->map())));
    }

    /**
     * Returns the serializer class with the schema loaded in
     *
     * @return Serializer
     */
    public function serializer()
    {
        return new Serializer($this);
    }

    /**
     * Returns the serialized data
     *
     * @param array $data
     * @return array
     */
    public static function serialize($data = [], $overrides = [])
    {
        return self::bind($overrides)->serializer()->serialize($data);
    }

    /**
     * Returns the unserializer class with the schema loaded in
     *
     * @return Unserializer
     */
    public function unserializer()
    {
        return new Unserializer($this);
    }

    /**
     * Returns the unserialized data
     *
     * @param array $data
     * @return array
     */
    public static function unserialize($data = [])
    {
        return self::bind()->unserializer()->unserialize($data);
    }
}
