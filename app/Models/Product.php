<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = [
        'category_id',
         'user_id',
         'name',
         'description',
         'price',
         'stored_at',
         'in_stock',
         'keyword',
         'created_at',
         'updated_at',
];
}
