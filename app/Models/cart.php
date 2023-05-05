<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'color',
        'size', 
        'no_of_items',
    ];
    protected $table = 'cart';
    public $timestamps = false;
    protected $primaryKey = 'id';
}