# Schematics

For nested data structures, you can access elements in deeper roots with a seperator '|'. 

### Creating a Schema Class
To use this library, you must first make 'Schema' classes that extend the base 'Schematic' class. These schema classes will have one required method, map(). The map() method must return an array of 'key' => 'value' pairs that map the data. 

```php
  class CarSchema extends Schematics\Schematic
  {
    public function map()
    {
      return [
        'make' => 'details|make',
        'model' => 'details|model',
        'year' => 'details|year'
      ];
    }
  }
```

### Using the Schemas

```php
  $carArray = [
    [
      'details' => [
        'make' => 'Ford',
        'model' => 'Mustang',
        'year' => 1488
      ],
      'color' => 'red'
    ],
    [
      'details' => [
        'make' => 'Dodge',
        'model' => 'Bad Boy',
        'year' => 19409
      ],
      'color' => 'clear'
    ],
    [
      'details' => [
        'make' => 'Honda',
        'model' => 'Civics',
        'year' => 'Some Year'
      ],
      'color' => 'Rusty'
    ],
  ];
  
  /**
   * Now you can serialize the data according to the schema as follows
   */
   $serializedData = CarSchema::serialize($carArray);

  /**
   * Pro Tip: You can also unserialize the data to 'unmap' the data
   */
  $unserializedData = CarSchema::unserialize($serializedData);
```

