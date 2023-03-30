<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'full_name', 'phone_number', 'username', 'date_birth', 'email', 'created_at', 'update_at'
    ];

    protected $hidden = [
        'password', 'deleted_at',
    ];
}
