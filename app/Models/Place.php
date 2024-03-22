<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Region;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'place_name',
        'place_info',
        'place_link',
        'place_point',
        'place_image',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}