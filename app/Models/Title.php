<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region;

class Title extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'title_name',
        'total_point',
        'image',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}


