<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2;

use Book\Part1\Chapter2\StaticAccess\ChildClass;
use Book\Part1\Chapter2\StaticAccess\ParentClass;

require __DIR__ . '/../../../vendor/autoload.php';

$parent = new ParentClass();
$child  = new ChildClass();

echo "\n\n\$parent::getStringSelf   =  {$parent::getStringSelf()}";
echo "\n\n\$parent::getStringStatic =  {$parent::getStringStatic()}";
echo "\n\n\$child::getStringSelf    =  {$child::getStringSelf()}";
echo "\n\n\$child::getStringStatic  =  {$child::getStringStatic()}";
