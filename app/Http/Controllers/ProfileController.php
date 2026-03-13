<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\DeleteProfileRequest;
use App\Http\Requests\Users\GetProfileRequest;
use App\Http\Requests\Users\UpdateProfileRequest;
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
        return view('profile.edit', $this->userService->getProfileEditData(auth()->user(), $user));
    }

    public function update(UpdateProfileRequest $request, User $user)
    {
        $data = $request->validated();

        $user = $this->userService->updateUser(
            $request->user(),
            $user,
            $data,
            $request->file('avatar'),
            false,
        );

        $payload = $this->userService->getProfileUpdatePayload($user);

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

        $payload = $this->userService->appendProfileDeleteRedirect($payload);

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return redirect()->route('login')->with('status', $payload['message']);
    }
}
