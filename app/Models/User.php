<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'user_creator',
        'user_appointment',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    public function user_creator(){
        return $this->belongsTo(User::class, 'user_creator');

    }

    public function user_role(){
        return $this->belongsTo(Role::class, 'user_role');
    } 

    public function user_appointment(){
        return $this->belongsTo(Appointment::class, 'user_appointment');
    }

    public function name(){
        return Attribute::make(
            set : fn(string $value) => mb_strtoupper($value, 'UTF-8'),
        );
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_connection' => 'datetime'

        ];
    }
}
