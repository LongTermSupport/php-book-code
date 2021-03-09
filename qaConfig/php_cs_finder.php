<?php

declare(strict_types=1);

// PRE REFACTOR
//const NOT_PATHS = [
//    'Part1/Chapter1/ForceInheritance/Person.php',
//    'Part1/Chapter1/StaticAccess/ParentClass.php',
//    'Part1/Chapter1/Inheritance/',
//    'Part1/Chapter2/truthy.php',
//    'Part1/Chapter2/object_comparison.php',
//    'Part1/Chapter2/void.php',
//    'Part1/Chapter3/early_return.php',
//    'Part1/Chapter3/ToyDI/SimpleServiceDefinition.php',
//];

const NOT_PATHS = [
    'Part1/Chapter1/',
    'Part1/Chapter2/ForceInheritance/Person.php',
    'Part1/Chapter2/StaticAccess/ParentClass.php',
    'Part1/Chapter2/Inheritance/',
    'Part1/Chapter2/inheritance.php',
];
return PhpCsFixer\Finder::create()
                        ->in([__DIR__ . '/../src', __DIR__ . '/../tests'])
                        ->notPath(NOT_PATHS);

