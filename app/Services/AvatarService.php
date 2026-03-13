<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AvatarService
{
    public function storeAvatar(UploadedFile $file, int $userId): string
    {
        $image = Image::make($file->getPathname())
            ->orientate()
            ->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            });

        $path = 'avatars/' . $userId . '/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($path, (string) $image->encode('jpg', 85));

        return $path;
    }

    public function deleteAvatar(User $user): void
    {
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }
    }
}

