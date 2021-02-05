<?php

declare(strict_types=1);

return PhpCsFixer\Finder::create()
                        ->in([__DIR__ . '/../src', __DIR__ . '/../tests'])
                        ->notPath('Part1/Chapter1/ForceInheritance/Person.php')
                        ->notPath('Part1/Chapter2/object_comparison.php')
                        ->notPath('Part1/Chapter1/StaticAccess/ParentClass.php');