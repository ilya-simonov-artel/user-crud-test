<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\SearchUserRequest;
use App\Http\Requests\Users\GetUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Repositories\UserRepository;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserService $userService,
    ) {
    }

    public function index(SearchUserRequest $request)
    {
        $validated = $request->validated();
        $search = trim((string) ($validated['search'] ?? ''));

        return view('admin.users.index', [
            'users' => $this->userRepository->searchPaginated($search, 15),
            'search' => $search,
        ]);
    }

    public function new()
    {
        return view('admin.users.create', [
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();
        $avatarRemove = (bool) ($data['avatar_remove'] ?? false);

        $user = $this->userService->createUser(
            $data,
            $request->file('avatar'),
            $avatarRemove,
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
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $avatarRemove = (bool) ($data['avatar_remove'] ?? false);

        $user = $this->userService->updateUser(
            $request->user(),
            $user,
            $data,
            $request->file('avatar'),
            $avatarRemove,
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

