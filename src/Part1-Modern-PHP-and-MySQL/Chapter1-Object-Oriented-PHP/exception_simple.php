<?php

declare(strict_types=1);

function dumpExceptionDetails(Throwable $throwable): string
{
    $class = $throwable::class;

    return "
Caught $class with message:

{$throwable->getMessage()}

Stack Trace:
{$throwable->getTraceAsString()}    
";
}

class FooException extends Exception
{
}

class BarException extends Exception
{

}

try {
    throw new BarException('something went wrong');
} catch (FooException | BarException $superCustomException) {
    echo "
This block is going to be executed, because we have caught one of the specific exception types we are catching
";
    echo dumpExceptionDetails($superCustomException);
} catch (Exception $exception) {
    echo "This block will not be executed, because the exception has already been caught";
    echo dumpExceptionDetails($exception);
} catch (Throwable $throwable) {
    echo "This block will not be executed, because the exception has already been caught";
    echo dumpExceptionDetails($throwable);
} finally {
    echo "
The finally block always happens..
";
}