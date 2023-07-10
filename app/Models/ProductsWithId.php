<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsWithId extends Model
{
    use HasFactory;

    protected $table = 'products_with_ids';

    protected $fillable = [
        'name',
        'price',
        'color',
    ];
}
