<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\RefreshesPermissionCache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles, HasPermissions, RefreshesPermissionCache;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'asp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserHonorGift::class);
    }

    public function userEducation(): HasMany
    {
        return $this->hasMany(UserHonorGift::class);
    }

    public function userAddress(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function UserSocial(): HasOne
    {
        return $this->hasOne(UserSocial::class);
    }

    public function UserFamily(): HasMany
    {
        return $this->hasMany(UserFamily::class);
    }

    public function UserHonorGift(): HasMany
    {
        return $this->hasMany(UserHonorGift::class);
    }

    public function UserPosting(): HasMany
    {
        return $this->hasMany(UserPosting::class);
    }

    public function UserSuccess(): HasMany
    {
        return $this->hasMany(UserSuccess::class);
    }

    public function UserWebPost(): HasMany
    {
        return $this->hasMany(UserWebPost::class);
    }

}
