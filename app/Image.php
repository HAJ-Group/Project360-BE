<?php

namespace App;

use Illuminate\Auth\Authenticatable as Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Image extends Model implements Authenticatable
{
    use Auth;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'annonce_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // RELATIONS

    public function announce() {
        return $this->belongsTo(Annonce::class);
    }

}
