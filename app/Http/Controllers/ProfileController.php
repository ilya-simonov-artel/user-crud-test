<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\DeleteProfileRequest;
use App\Http\Requests\Users\GetProfileRequest;
use App\Http\Requests\Users\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function index(Request $request)
    {
        return redirect()->route('profile.edit', $request->user());
    }

    public function show(GetProfileRequest $request, User $user)
    {

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        $this->userService->assertCurrentUser(auth()->user(), $user);

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateProfileRequest $request, User $user)
    {
        $this->userService->assertCurrentUser(auth()->user(), $user);

        $data = $request->validated();
        $avatarRemove = (bool) ($data['avatar_remove'] ?? false);

        $user = $this->userService->updateUser(
            $request->user(),
            $user,
            $data,
            $request->file('avatar'),
            $avatarRemove,
            false,
        );

        $payload = [
            'message' => 'Profile updated successfully.',
            'data' => new UserResource($user),
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return redirect()
            ->route('profile.edit', $user)
            ->with('status', $payload['message']);
    }

    public function destroy(DeleteProfileRequest $request, User $user)
    {
        $payload = $this->userService->deleteUser($request->user(), $user, false);

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $payload['redirect'] = route('login');

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return redirect()->route('login')->with('status', $payload['message']);
    }
}

