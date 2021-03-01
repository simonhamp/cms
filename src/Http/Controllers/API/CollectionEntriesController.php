<?php

namespace Statamic\Http\Controllers\API;

use Statamic\Http\Resources\API\EntryResource;

class CollectionEntriesController extends ApiController
{
    protected $filterPublished = true;

    public function index($collection)
    {
        return app(EntryResource::class)::collection(
            $this->filterSortAndPaginate($collection->queryEntries())
        );
    }

    public function show($collection, $entry)
    {
        $this->abortIfUnpublished($entry);

        return app(EntryResource::class)::make($entry);
    }
}
