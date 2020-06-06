<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = ['title', 'type', 'description', 'price', 'address', 'city', 'position_map', 'status', 'rent'];

    protected $hidden = ['created_at', 'updated_at', 'annoncer_id'];

    //Relationships

    public function annoncer()
    {
        return $this->belongsTo('App\Annoncer');
    }

}
