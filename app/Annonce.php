<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'surface',
        'pieces',
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

    public function gallery(){
        return $this->hasMany(Timage::class);
    }
}
