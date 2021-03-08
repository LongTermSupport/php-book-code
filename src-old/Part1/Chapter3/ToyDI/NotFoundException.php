<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyDI;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

final class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}
