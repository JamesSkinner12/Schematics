<?php

require_once(__DIR__ . "/vendor/autoload.php");
  class CarSchema extends Schematics\Schematic
  {
    public function map()
    {
      return [
        'details' => 'details',
      ];

    }

    public function schemas() 
    {
      return [
//          'details' => DetailSchema::class
      ];
    }
  }

  class DetailSchema extends Schematics\Schematic
  {
    public function map()
    {
      return [
        'ma' => 'make',
        'mo' => 'model',
        'ye' => 'year'
      ];
    }
  }

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
   print_r($serializedData);
