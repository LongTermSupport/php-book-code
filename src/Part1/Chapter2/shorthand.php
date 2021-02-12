<?php

declare(strict_types=1);

$object = new class {
    private ?object $property1;
    private ?object $property2 = null;
    public bool     $bool1     = true;
    public bool     $bool2     = false;

    public function __construct()
    {
        $this->property1 = new class() {
            public string $thing = 'blah';
        };
    }

    public function getProperty1(): ?object
    {
        return $this->property1;
    }

    public function getProperty2(): ?object
    {
        return $this->property2;
    }
};

/**
 * First lets compare some classic if/else code with a ternary operator
 */
// Classic if/else code checking
if ($object->bool1 === true) {
    $value1 = 'bool 1 is true';
} else {
    $value1 = 'bool 1 is false';
}

// Ternary
// Note - if your variable or value is not a bool, it will be type juggled to one.
// You can make ternary strict by checking for identity (===) with true/false directly
$value2 = $object->bool1 === true ? 'bool 1 is true' : 'bool 1 is false';

echo "\n" . '$value1===$value2? ' . var_export($value1 === $value2, true);


// classic null checking monstrosity (deliberately verbose)
if ($object->getProperty2() === null) {
    if ($object->getProperty1() === null) {
        $value3 = null;
    } else {
        if ($object->getProperty1()->thing === null) {
            $value3 = null;
        } else {
            $value3 = $object->getProperty1()->thing;
        }
    }
} else {
    if ($object->getProperty2() === null) {
        $value3 = null;
    } elseif ($object->getProperty2()->foo === null) {
        $value3 = null;
    } else {
        $value3 = $object->getProperty2()->foo;
    }
}

// null coalesce & nullsafe operator
$value4 = $object?->getProperty2()?->foo ?? $object?->getProperty1()?->thing;

echo "\n" . '$value3===$value4? ' . var_export($value3 === $value4, true);
