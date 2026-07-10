<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\Common\ListQueryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ListUsersRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Support\ApiResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service
    ) {}

    public function index(ListUsersRequest $request)
    {
        $dto = new ListQueryDTO(

            search: $request->validated('search'),

            sort: $request->validated('sort'),

            direction: $request->validated('direction', 'asc'),

            perPage: (int) $request->validated('per_page', 15),

            page: (int) $request->validated('page', 1),

        );

        $users = $this->service->list($dto);

        return ApiResponse::success(
            data: UserResource::collection($users),
            message: 'Users fetched successfully.',
            meta: [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ]
        );
    }

    public function show(int $id)
    {
        $user = $this->service->find($id);

        return ApiResponse::success(
            data: new UserResource($user),
            message: 'User fetched successfully.'
        );
    }
}
