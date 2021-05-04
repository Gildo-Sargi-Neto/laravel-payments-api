<?php

namespace App\Http\Controllers\api;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Creates a user
     * POST /api/user
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request)
    {
        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'type' => $request->type,
            'password' => bcrypt($request->password)
        ];

        $createUserResponse = $this->userService->create($params);

        return response()->json($createUserResponse);
    }
}
