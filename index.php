<?php

require 'vendor/autoload.php';


$container = new \Andreip\Dicontainer\Container();
$container->bindParameters(\Andreip\Dicontainer\Dog::class, ['name' => 'Rex', 'speakWord' => 'Woof']);
$container->bindAbstract(\Andreip\Dicontainer\Seasoning::class, \Andreip\Dicontainer\Salt::class);

$dog = $container->make(\Andreip\Dicontainer\Dog::class);

print $dog->speak();

print $dog->speak();
print PHP_EOL;
print $dog->hasChip();

