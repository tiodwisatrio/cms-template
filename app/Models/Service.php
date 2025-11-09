<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'order'
    ];

    protected $casts = [
        'status' => 'integer',
        'order' => 'integer',
    ];

    public function getStatusLabelAttribute()
    {
        return $this->status === 1 ? 'Aktif' : 'Tidak Aktif';
    }

}
