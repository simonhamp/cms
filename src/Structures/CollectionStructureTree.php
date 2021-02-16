<?php

namespace Statamic\Structures;

use Statamic\Events\CollectionStructureTreeDeleted;
use Statamic\Events\CollectionStructureTreeSaved;
use Statamic\Facades\Blink;
use Statamic\Facades\Collection;
use Statamic\Facades\Site;
use Statamic\Facades\Stache;

class CollectionStructureTree extends Tree
{
    public function structure()
    {
        return Blink::once('collection-tree-structure-'.$this->handle(), function () {
            return Collection::findByHandle($this->handle())->structure();
        });
    }

    public function path()
    {
        $path = Stache::store('collection-trees')->directory();

        if (Site::hasMultiple()) {
            $path .= $this->locale().'/';
        }

        $handle = $this->collection()->handle();

        return "{$path}{$handle}.yaml";
    }

    protected function dispatchSavedEvent()
    {
        CollectionStructureTreeSaved::dispatch($this);
    }

    protected function dispatchDeletedEvent()
    {
        CollectionStructureTreeDeleted::dispatch($this);
    }

    public function collection()
    {
        return $this->structure()->collection();
    }
}