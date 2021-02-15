<?php

declare(strict_types=1);

namespace Book\Part1\Chapter3\ToyMvc\Model\Repository;

use Book\Part1\Chapter3\ToyMvc\Model\Collection\CategoryCollection;
use Book\Part1\Chapter3\ToyMvc\Model\Collection\PostCollection;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\CategoryEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\PostEntity;
use Book\Part1\Chapter3\ToyMvc\Model\Entity\Uuid;

class CategoryRepository
{
    /** @var CategoryEntity[]* */
    private array $data;

    public function __construct()
    {
        $this->buildDemoData();
    }

    private function buildDemoData(): void
    {
        $cat1Id     = Uuid::create();
        $cat2Id     = Uuid::create();
        $this->data = [
            new CategoryEntity(
                $cat1Id,
                'Category 1',
                new PostCollection(
                    new PostEntity(
                        Uuid::create(),
                        'Post 1',
                        <<<'HTML'
                        You better eat a reality sandwich before you walk back in that boardroom feature creep you must be muted yet take five, punch the tree, and come back in here with a clear head. Looks great, can we try it a different way. Due diligence obviously big boy pants. Rock Star/Ninja cross sabers pulling teeth. 
                        HTML
                    ),
                    new PostEntity(
                        Uuid::create(),
                        'Post 2',
                        <<<'HTML'
                        Optimize for search form without content style without meaning. Low hanging fruit that is a good problem to have if you want to motivate these clowns, try less carrot and more stick, and we need to crystallize a plan pig in a python. Those options are already baked in with this model. Staff engagement great plan!
                        HTML
                    ),
                )
            ),
            new CategoryEntity(
                $cat2Id,
                'Category 2',
                new PostCollection(
                    new PostEntity(
                        Uuid::create(),
                        'Post 3',
                        <<<'HTML'
                        let me diarize this, and we can synchronise ourselves at a later timepoint are we in agreeance pig in a python window-licker, nor can you ballpark the cost per unit for me. Dog and pony show. Great plan! let me diarize this,
                        HTML
                    ),
                    new PostEntity(
                        Uuid::create(),
                        'Post 4',
                        <<<'HTML'
                        Can we jump on a zoom race without a finish line vertical integration, yet out of scope we need to crystallize a plan turn the crank.
                        HTML
                    ),
                )
            ),

        ];
    }

    public function loadAll(): CategoryCollection
    {
        /** Imagine that this method uses an ORM layer to build entities from the DB */
        return new CategoryCollection(...$this->data);
    }
}