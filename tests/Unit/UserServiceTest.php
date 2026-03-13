<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AvatarService;
use App\Services\UserService;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    public function test_admin_cannot_delete_self_in_admin_context(): void
    {
        $actor = new User(['id' => 1]);

        $userRepository = Mockery::mock(UserRepository::class);
        $avatarService = Mockery::mock(AvatarService::class);

        $userRepository->shouldNotReceive('delete');
        $avatarService->shouldNotReceive('deleteAvatar');

        $service = new UserService($userRepository, $avatarService);
        $result = $service->deleteUser($actor, $actor, true);

        $this->assertFalse($result['ok']);
        $this->assertSame('You cannot delete your own account from the admin panel.', $result['message']);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $actor = new User();
        $actor->setAttribute('id', 1);
        $target = new User();
        $target->setAttribute('id', 2);

        $userRepository = Mockery::mock(UserRepository::class);
        $avatarService = Mockery::mock(AvatarService::class);

        $avatarService->shouldReceive('deleteAvatar')->once()->with($target);
        $userRepository->shouldReceive('delete')->once()->with($target);

        $service = new UserService($userRepository, $avatarService);
        $result = $service->deleteUser($actor, $target, true);

        $this->assertTrue($result['ok']);
        $this->assertSame('User deleted successfully.', $result['message']);
    }

    public function test_update_user_ignores_empty_password(): void
    {
        $actor = new User(['id' => 1]);
        $target = new User(['id' => 2]);

        $userRepository = Mockery::mock(UserRepository::class);
        $avatarService = Mockery::mock(AvatarService::class);

        $userRepository->shouldReceive('update')
            ->once()
            ->with($target, Mockery::on(function (array $data) {
                return !array_key_exists('password', $data)
                    && $data['name'] === 'Updated Name';
            }))
            ->andReturn($target);

        $avatarService->shouldNotReceive('deleteAvatar');

        $service = new UserService($userRepository, $avatarService);
        $service->updateUser($actor, $target, [
            'name' => 'Updated Name',
            'password' => '',
        ], null, false, true);

        $this->assertTrue(true);
    }
}


