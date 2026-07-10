<?php

namespace App\Repositories\Eloquent;

use App\DTOs\Auth\RegisterDTO;
use App\DTOs\Common\ListQueryDTO;
use App\DTOs\User\StoreUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\Query\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

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

    public function register(RegisterDTO $dto): User
    {
        return User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
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
                $dto->direction->value
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

    public function create(StoreUserDTO $dto): User
    {
        return User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password)
        ]);
    }

    public function findOrFail(int $id): User
    {
        return User::query()->findOrFail($id);
    }

    public function update(UpdateUserDTO $dto): User
    {
        $user = $this->findOrFail($dto->id);

        $user->update([
            'name' => $dto->name,
            'email' => $dto->email,
        ]);

        if (!empty($dto->password)) {
            $user->update([
                'password' => Hash::make($dto->password),
            ]);
        }

        return $user->refresh();
    }

    public function delete(int $id): bool
    {
        $user = $this->findOrFail($id);

        return (bool) $user->delete();
    }
}
