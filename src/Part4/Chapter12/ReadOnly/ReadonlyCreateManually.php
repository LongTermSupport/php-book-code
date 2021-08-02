<?php

declare(strict_types=1);

namespace Book\Part4\Chapter12\ReadOnly;

class ReadonlyCreateManually
{
    private readonly mixed $expensiveThing;

    public function __construct(public readonly int $foo){
        // do something to generate the expensive thing
        $this->expensiveThing='ooh that was hard work';
    }

    public function with(int $foo):self{
        $new=new static($foo);
        $new->expensiveThing=$this->expensiveThing;
        return $new;
    }
}