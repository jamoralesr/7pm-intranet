<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}
