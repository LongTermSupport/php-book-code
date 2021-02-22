<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3;

/**
 * Note the error returns are towards the end of the function
 * - a dead giveaway that this should be returning early
 */
function isValidValueNested(int|null $value): bool
{                                            # cylomatic complexity 1
    if (is_int($value)) {                     # cylomatic complexity 2
        if ($value > 10) {                   # cylomatic complexity 3
            if ($value < 200) {              # cylomatic complexity 4
                return true;
            } else {                         # cylomatic complexity 5
                return false;
            }
        } else {                             # cylomatic complexity 6
            return false;
        }
    } else {                                   # cylomatic complexity 7
        return false;
    }
}

/**
 * By checking for errors and returning early,
 * we can totally avoid any nesting and it is sooo much easier to read
 */
function isValidValueEarlyReturn(int|null $value): bool
{                                        # cylomatic complexity 1
    if (null === $value) {                 # cylomatic complexity 2
        return false;
    }
    if ($value < 10) {                   # cylomatic complexity 3
        return false;
    }
    if ($value > 200) {                  # cylomatic complexity 4
        return false;
    }

    return true;
}

echo 'isValidValueNested(20)===isValidValueEarlyReturn(20)? ' .
     var_export(isValidValueNested(20) === isValidValueEarlyReturn(20), true);
