<?php

declare(strict_types=1);

namespace Book\Part1\Chapter1;

use Book\Part1\Chapter1\ExceptionSimple\BarException;
use Book\Part1\Chapter1\ExceptionSimple\Dumper;
use Book\Part1\Chapter1\ExceptionSimple\FooException;
use Exception;
use Throwable;

$dumper = new Dumper();

try {
    throw new BarException('something went wrong');
} catch (FooException | BarException $superCustomException) {
    echo '
This block is going to be executed, because we have caught one of the specific exception types we are catching
';
    echo $dumper($superCustomException);
} catch (Exception $exception) {
    echo 'This block will not be executed, because the exception has already been caught';
    echo $dumper($exception);
} catch (Throwable $throwable) {
    echo 'This block will not be executed, because the exception has already been caught';
    echo $dumper($throwable);
} finally {
    echo '
The finally block always happens..
';
}
