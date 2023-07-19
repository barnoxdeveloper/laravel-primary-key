<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductWithUlid extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'price',
        'color',
    ];

    protected $table = 'product_with_ulids';

    protected $primaryKey = 'id';

    public $incrementing = false;
}
