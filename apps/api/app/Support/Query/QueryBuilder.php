<?php

namespace App\Support\Query;

use Illuminate\Database\Eloquent\Builder;

class QueryBuilder
{
    public function apply(
        Builder $query,
        array $searchable = [],
        array $sortable = []
    ): Builder {

        /*
        |-----------------------------------
        | Search
        |-----------------------------------
        */

        if ($search = request('search')) {

            $query->where(function ($q) use ($searchable, $search) {

                foreach ($searchable as $column) {

                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        /*
        |-----------------------------------
        | Sort
        |-----------------------------------
        */

        $sort = request('sort');

        $direction = request('direction', 'asc');

        if ($sort && in_array($sort, $sortable)) {

            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}
