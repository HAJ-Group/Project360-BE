<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'annonce_id',
        'annoncer_id',
    ];
    public function annoncer()
    {
        return $this->belongsTo(Annoncer::class);
    }
    public function announce()
    {
        return $this->belongsTo(Annonce::class);
    }
}
