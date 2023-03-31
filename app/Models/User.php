<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 
        'password',
        'phone_number', 
        'username', 
        'date_birth', 
        'email', 
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sendPasswordResetNotification($token) {

        $url = 'http://localhost:8000/api/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
