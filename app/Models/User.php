<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        $adminEmail = env('ADMIN_EMAIL');

        return $panel->getId() === 'admin' && $this->email === $adminEmail;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return Cache::remember('filament_avatar_url', 60 * 60, function () {
            $profile = ImageProfile::first();
            if ($profile?->foto_resume) {
                return Storage::disk('cloudinary')->url($profile->foto_resume);
            }
            return asset('template/assets/img/content/foto-resume.jpg');
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'address_id',
        'address_en',
        'phone',
        'discord',
        'github',
        'instagram',
        'linkedin',
        'tiktok',
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
}
