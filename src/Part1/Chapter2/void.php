<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2;

function yo(?string $yo): void
{
    if ($yo === null) {
        echo 'yo';

        // in a void function, we use an empty return to break out of teh function if we are done
        return;
    }
    echo $yo;
}

$void = yo('hey!');

$noReturn = (static function (): void {
})();

echo "\n\$void=" . var_export($void, true);

echo "\n\$noReturn=" . var_export($noReturn, true);

echo "\n\$void === \$noReturn? " . var_export($void === $noReturn, true);
