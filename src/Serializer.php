<?php

namespace Schematics;

class Serializer
{
    protected $schema;
    protected $data;

    public function __construct(Schematic $schema)
    {
        $this->schema = $schema;
    }

    public function serialize($data = [])
    {
        $this->data = $data;
        foreach (array_keys($this->schema->map()) as $name) {
            try {
                $tmp = $this->applyItem($name, $data);
                if ($this->schema->itemHasSchema($name)) {
                    $tmp = $this->applySchema($name, $tmp);
                }
                $out[$name] = $tmp;
            } catch (\Exception $e) {
                $out[$name] = null;
                echo "||" . $e->getMessage() . " ||\n";
            }
        }
        return (!empty($out)) ? $out : null;
    }

    public function applySchema($name, $values = [])
    {
        $schema = $this->schema->getSchema($name);
        $out = [];
        $keys = array_keys($values);
        $tmpKey = reset($keys);
        if (is_int($tmpKey)) {
            foreach ($keys as $key) {
                $out[] = $schema->serialize($values[$key]);
            }
        }
        if (!is_int($tmpKey)) {
            $out = $schema->serialize($values);
        }
        return $out;
    }

    public function isMultiItem($data)
    {
        $keys = array_keys($data);
        $key = reset($keys);
        return is_int($key);
    }

    public function applyItem($name, $data = [])
    {
        $keys = explode("|", $this->schema->map()[$name]);
        if (!$this->isMultiItem($data)) {
          foreach ($keys as $key) {
              if (!empty($data[$key])) {
                  $data = $data[$key];
              } else {
                  return null;
              }
          }
        } else {
            foreach ($data as $itm) {
                foreach ($keys as $key) {
                    $itm = $itm[$key];
                }
                $tmp[] = $itm;
            }
            return $tmp;
        }
        return $data;
    }


}
