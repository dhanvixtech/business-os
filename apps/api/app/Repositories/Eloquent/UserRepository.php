<?php

namespace App\Repositories\Eloquent;

use App\DTOs\Common\ListQueryDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\Query\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    private const DEFAULT_SORT = 'id';

    private const DEFAULT_DIRECTION = 'desc';

    private const SEARCHABLE = [
        'name',
        'email',
    ];

    private const SORTABLE = [
        'id',
        'name',
        'email',
        'created_at',
    ];

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function list(ListQueryDTO $dto)
    {
        $query = User::query();

        // Search
        if (!empty($dto->search)) {
            $query->where(function ($q) use ($dto) {

                foreach (self::SEARCHABLE as $column) {
                    $q->orWhere($column, 'like', "%{$dto->search}%");
                }
            });
        }

        // Sort
        if (
            !empty($dto->sort) &&
            in_array($dto->sort, self::SORTABLE)
        ) {
            $query->orderBy(
                $dto->sort,
                $dto->direction
            );
        } else {
            $query->orderBy(
                self::DEFAULT_SORT,
                self::DEFAULT_DIRECTION
            );
        }

        return $query->paginate(
            perPage: $dto->perPage,
            page: $dto->page
        );
    }

    public function paginate(ListQueryDTO $dto): LengthAwarePaginator
    {
        return User::query()

            ->when(
                request('search'),
                function ($query, $search) {

                    $query->where(function ($q) use ($search) {

                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            )

            ->when(
                request('sort'),
                function ($query, $sort) {

                    $allowed = [
                        'id',
                        'name',
                        'email',
                        'created_at'
                    ];

                    if (in_array($sort, $allowed)) {

                        $query->orderBy(
                            $sort,
                            request('direction', 'asc')
                        );
                    }
                }
            )

            ->paginate(
                request('per_page', 15)
            );
    }

    public function findOrFail(int $id): User
    {
        return User::query()->findOrFail($id);
    }
}
