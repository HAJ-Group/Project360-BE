<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annoncer extends Model
{
    protected $fillable = [
        'user_id', 'last_name','first_name','phone','address','city','email','picture','date_of_birth'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function annonces() {
        return $this->hasMany(Annonce::class);
    }
}
