<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{

    public function annoncer() {
        return $this->belongsTo(Annoncer::class);
    }
}
