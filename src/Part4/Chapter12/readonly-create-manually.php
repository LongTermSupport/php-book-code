<?php

declare(strict_types=1);

namespace Book\Part4\Chapter12;

use Book\Part4\Chapter12\ReadOnly\ReadonlyCreateManually;

$dto = new ReadonlyCreateManually(1);
echo "\nOriginal DTO: " . var_export($dto, true);

$new = $dto->with(2);
echo "\nNew Object created: " . var_export($new, true);