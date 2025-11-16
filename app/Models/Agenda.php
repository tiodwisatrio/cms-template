<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'start_date',
        'end_date',
        'image',
    'status',
    ];
}
