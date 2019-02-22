<?php

namespace Schematics;

class Unserializer
{
    protected $schema;

    public function __construct(Schematic $schema)
    {
        $this->schema = $schema;
    }

    public function unserialize($data = [])
    {
        $out = [];
        foreach ($data as $name => $values) {
            if ($this->schema->itemExists($name)) {
                if ($this->schema->itemHasSchema($name)) {
                    $values = $this->unapplySchema($name, $values);
                }
                $tmp = self::buildBranch($this->schema->findKeys($name), $values);
                $out = array_merge_recursive($out, $tmp);
            }
        }
        return $out;
    }

    public function buildBranch($keys, $value)
    {
        $key = array_shift($keys);
        $out[$key] = (!empty($keys)) ? self::buildBranch($keys, $value) : $value;
        return (!empty($out)) ? $out : null;
    }

    public function unapplySchema($name, $values = [])
    {
        $schema = $this->schema->getSchema($name);
        $keys = array_keys($values);
        $tmpKey = reset($keys);
        if (is_int($tmpKey)) {
            foreach ($keys as $key) {
                $out[] = $schema->unserialize($values[$key]);
            }
        }
        if (!is_int($tmpKey)) {
            $out = $schema->unserialize($values);
        }
        return $out;
    }

    public function unapplyItem($name, $data = [])
    {
        $keys = explode("|", $this->schema->map()[$name]);
        foreach ($keys as $key) {
            $data[$key] = $data;
        }
        return $data;
    }
}
