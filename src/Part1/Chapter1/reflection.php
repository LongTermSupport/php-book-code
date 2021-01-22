<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\ReflectionFun\Kid;

echo "
We're going to take an example object, nothing fancy
";
$instance = new Kid('Anna', 9);

$reflection = new \ReflectionObject($instance);

echo "
You can get information about a class/object, such as the class methods
";
var_dump($reflection->getMethods());

echo "

And now watch as we do things that you would not normally think is possible,

We're taking a private method and invoking it from outside the scope of the object.

";

echo "
Her name is " . $instance->getName();

$method = $reflection->getMethod('nameChange');
$method->setAccessible(true);
$method->invoke($instance, 'Gwenn');

echo "
And now her name is " . $instance->getName();