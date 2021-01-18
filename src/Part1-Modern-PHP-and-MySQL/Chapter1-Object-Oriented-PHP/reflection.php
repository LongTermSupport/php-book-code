<?php

declare(strict_types=1);

echo "

Reflection can be really useful

";

class Kid
{
    public function __construct(
        private string $name,
        private int $age
    ) {
    }

    private function nameChange(string $newName): void
    {
        $this->name = $newName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}

$instance = new Kid('Anna', 9);

$reflection = new ReflectionObject($instance);

echo "
You can get information about a class/object
";
var_dump($reflection->getMethods());

echo "

And you can do things you aren't really supposed to be able to do...

";

echo "
Her name is " . $instance->getName();

$method = $reflection->getMethod('nameChange');
$method->setAccessible(true);
$method->invoke($instance, 'Gwenn');

echo "
And now her name is " . $instance->getName();