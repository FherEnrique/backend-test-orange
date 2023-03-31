<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use  HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'SKU', 'name', 'stock', 'price', 'description', 'image', 'created_at', 'update_at', 
    ];

    protected $hidden = [
        'deleted_at',
    ];
}
