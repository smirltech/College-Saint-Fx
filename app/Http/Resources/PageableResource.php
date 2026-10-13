<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PageableResource extends ResourceCollection
{

    private $pageable;

    public function __construct($resource)
    {
        $this->pageable = [
            'size' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'first_item' => $resource->firstItem(),
            'last_item' => $resource->lastItem(),
            'total_pages' => $resource->lastPage(),
            'total_elements' => $resource->total(),
        ];

        $resource = $resource->getCollection();
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'pageable' => $this->pageable,
            'data' => $this->collection

        ];
    }
}