<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Title;
use App\Models\Place;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'prefecture',
    ];

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function titles()
    {
        return $this->hasMany(Title::class);
    }
}
