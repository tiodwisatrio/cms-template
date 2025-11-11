<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurValue extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'order',
    ];
}
