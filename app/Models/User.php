<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = [
        'firstName',
        'initials',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // This accessor CAN be appended
    protected function initials(): Attribute
    {
        return Attribute::make(
            get: fn () => preg_replace('/[^A-Z]/', '', $this->name),
        );
    }

    // This accessor CANNOT be appended, calling `toArray()`
    // on a model tries to call the old style
    // `getFirstNameAttribute()` method
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::before($this->name, ' '),
        );
    }
}
