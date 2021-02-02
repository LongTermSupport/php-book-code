<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2;

//A simple object that gives its object ID when we cast it to string
$instance = new class() {
    public function __toString(): string
    {
        return (string)spl_object_id($this);
    }
};
echo "\n\$instance ID: {$instance}";

// Now creating a simple reference to that instance
$reference1 = $instance;
echo "\n\$reference1 ID: {$reference1}";

// Now creating a function and calling, passing in the instance
(static function (object $reference2): void {
    echo "\n\$reference2 ID: {$reference2}";
})($reference1);

// Finally, getting a new instance
$newInstance = clone $instance;
echo "\n\$newInstance ID: {$newInstance}\n";
