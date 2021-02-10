<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model;

use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;

/**
 * This class represents a basic database or persistence layer. It is clearly just for demo purposes :)
 */
class Database
{
    public const TABLE_CATEGORY = 'category';
    public const TABLE_POST     = 'post';
    private array $storage;

    public function __construct()
    {
        $this->storage[self::TABLE_CATEGORY] = [];
        $this->storage[self::TABLE_POST]     = [];
    }

    private function validTable(string $table): self
    {
        if (false === array_key_exists(key: $table, array: $this->storage)) {
            throw new \InvalidArgumentException('Invalid table ' . $table);
        }

        // fluent interface - basically means returns $this and allows easy chaining
        return $this;
    }

    public function load(Uuid $uuid, string $table): ?array
    {

        $uuidString = (string)$uuid;

        return $this->validTable($table)->storage[$table][$uuidString] ?? null;
    }

    public function save(string $table, array $data): Uuid
    {
        $uuid       = $data[Uuid::DATA_KEY] ?? Uuid::create();
        $uuidString = (string)$uuid;

        $this->validTable($table)->storage[$table][$uuidString] = $data;

        return $uuid;
    }
}