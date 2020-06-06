<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annoncer extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function annonces() {
        return $this->hasMany(Annonce::class);
    }
}
