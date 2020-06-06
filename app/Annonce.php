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
        'annoncer_id',
    ];

    public function annoncer()
    {
        return $this->belongsTo(Annoncer::class);
    }
}
