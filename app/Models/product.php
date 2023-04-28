<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


    class product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];
    
    protected $table = 'product';
    
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Define your relationships with other models here
}
