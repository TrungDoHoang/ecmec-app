<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait HasPaginatedResponse
{
    protected function paginatedResponse(LengthAwarePaginator $paginator, $collection = null)
    {
        return [
            'currentPage' => $paginator->currentPage(),
            'lastPage'    => $paginator->lastPage(),
            'perPage'     => $paginator->perPage(),
            'total'        => $paginator->total(),
            'from'         => $paginator->firstItem(),
            'to'           => $paginator->lastItem(),
            'data'         => $collection ?? $paginator->items(),
        ];
    }
}
