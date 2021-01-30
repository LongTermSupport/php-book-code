<?php

declare(strict_types=1);

namespace Book\Part1\Chapter2;

/**
 * Don't want to embed anything in the string.
 */
$singleQuoted = 'This is a single quoted string. It can contain all kind of characters such as $"\n#, '
                . ';nothing will happen, the raw characters will just be included in your string.'
                . ' This makes it a very safe one to use. The main time it gets annoying, '
                . 'is when you want your string to contain \' characters, '
                . 'as then you have to remember to escape them with \\';
echo "\n{$singleQuoted}\n";

$nowDoc = <<<'DELIM'
This is a a NOWDOC string. The definition looks more verbose than single quoted, and you have to type a few more characters. 
What you get in return though is that you can include all ''' you want with no escaping.
You can include all the $'%"\n special characters you want and they will just be included in the string as is
DELIM;
echo "\n{$nowDoc}\n";

/**
 * Do want to embed things directly in the string.
 */
$thingToEmbed = ' [embed me pls ]';
$otherThing   = new class() {
    public function getStuff(): string
    {
        return ' (some stuff) ';
    }
};

$doubleQuoted = "
A double quoted string can include other variables directly such as {$thingToEmbed}.
You can also directly embed more complex things if you wrap it in curly braces, like this {$otherThing->getStuff()}
As with single quoted strings, you have to escape any \" characters you want to include. 
\nOne nice feature of this kind of string is that you can easily\n embed \n\t special\n\t\t characters
";
echo "\n{$doubleQuoted}\n";

$hereDoc = <<<DELIM
A heredoc is exactly like the double quoted string, but comes with the benefit of " and ' being included with no hassle. 
You can also embed things like {$thingToEmbed} and {$otherThing->getStuff()}.
HEREDOC strings will also let you \n embed\n\t special\n\t\t characters.
DELIM;
echo "\n{$hereDoc}\n";
