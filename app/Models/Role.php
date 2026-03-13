<?php

namespace App\Models;

use App\Enums\RoleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function descriptionLabel(): string
    {
        return $this->display_name
            ?? RoleType::tryFrom($this->name)?->description()
            ?? $this->name;
    }
}
