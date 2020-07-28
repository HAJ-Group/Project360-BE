<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class Annonce extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'price',
        'address',
        'city',
        'position_map',
        'status',
        'rent',
        'premium',
        'annoncer_id',
    ];

    public function annoncer()
    {
        return $this->belongsTo(Annoncer::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }
}
