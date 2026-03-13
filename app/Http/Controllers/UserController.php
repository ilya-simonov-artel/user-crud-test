<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\SearchUserRequest;
use App\Http\Requests\Users\GetUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function index(SearchUserRequest $request)
    {
        $viewData = $this->userService->getAdminIndexData($request->validated());

        return view('admin.users.index', $viewData);
    }

    public function new()
    {
        return view('admin.users.create', $this->userService->getAdminUserFormData());
    }

    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->createUser(
            $data,
            $request->file('avatar'),
        );

        return redirect()->route('admin.users.show', $user)
            ->with('status', 'User created successfully.');
    }

    public function show(GetUserRequest $request, User $user)
    {
        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', $this->userService->getAdminUserFormData($user));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user = $this->userService->updateUser(
            $request->user(),
            $user,
            $data,
            $request->file('avatar'),
            true,
        );

        return redirect()->route('admin.users.edit', $user)
            ->with('status', 'User updated successfully.');
    }

    public function destroy(DeleteUserRequest $request, User $user)
    {
        $payload = $this->userService->deleteUser($request->user(), $user, true);

        if ($request->expectsJson()) {
            return response()->json(
                ['message' => $payload['message']],
                $payload['ok'] ? 200 : 422,
            );
        }

        return redirect()->route('admin.users.index')->with('status', $payload['message']);
    }
}
