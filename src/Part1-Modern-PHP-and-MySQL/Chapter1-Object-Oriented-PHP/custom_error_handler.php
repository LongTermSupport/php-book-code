<?php

declare(strict_types=1);

const DEBUG_MODE = true;

/**
 * This bit of magic boilerplate will turn any old fashioned PHP error into an ErrorException which you can then catch
 * in your code.
 */
set_error_handler(static function (int $severity, string $message, string $file, int $line) {
    if (error_reporting() & $severity) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
});

/**
 * This bit of magic boilerplate becomes your ultimate fallback should any exceptions bubble past all the catch blocks
 * in your code.
 */
set_exception_handler(static function (Throwable $throwable) {
    if (false === DEBUG_MODE) {
        echo "
        An error has occurred, 
        
        please look at a happy picture whilst our engineers fix this for you :)
        
";

        return;
    }
    echo "
    
You are clearly a developer, please see a load of useful debug info:
    
" . var_export($throwable, true);
});

echo "

And now to do something silly

";

substr(string: new stdClass(), offset: 'cheese');
