<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AvatarService $avatarService,
    ) {
    }

    public function assertCurrentUser(User $actor, User $target): void
    {
        if (!$actor->is($target)) {
            abort(403);
        }
    }

    public function createUser(array $data, ?UploadedFile $avatar, bool $avatarRemove): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        $this->applyAvatar($user, $avatar, $avatarRemove);

        return $user;
    }

    public function updateUser(
        User $actor,
        User $target,
        array $data,
        ?UploadedFile $avatar,
        bool $avatarRemove,
        bool $isAdminContext,
    ): User {
        if (!$isAdminContext) {
            $this->assertCurrentUser($actor, $target);
        }

        if (array_key_exists('password', $data)) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
        }

        $this->userRepository->update($target, $data);
        $this->applyAvatar($target, $avatar, $avatarRemove);

        return $target;
    }

    public function deleteUser(User $actor, User $target, bool $isAdminContext): array
    {
        if ($isAdminContext && $actor->is($target)) {
            return [
                'ok' => false,
                'message' => 'You cannot delete your own account from the admin panel.',
            ];
        }

        if (!$isAdminContext) {
            $this->assertCurrentUser($actor, $target);
        }

        $this->avatarService->deleteAvatar($target);
        $this->userRepository->delete($target);

        return [
            'ok' => true,
            'message' => $isAdminContext ? 'User deleted successfully.' : 'Account deleted successfully.',
        ];
    }

    private function applyAvatar(User $user, ?UploadedFile $avatar, bool $avatarRemove): void
    {
        if ($avatarRemove) {
            $this->avatarService->deleteAvatar($user);
            $user->avatar_path = null;
        }

        if ($avatar) {
            $this->avatarService->deleteAvatar($user);
            $user->avatar_path = $this->avatarService->storeAvatar($avatar, $user->id);
        }

        if ($user->isDirty('avatar_path')) {
            $this->userRepository->save($user);
        }
    }
}

