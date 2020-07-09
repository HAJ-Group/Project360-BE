<?php

namespace App;

use Illuminate\Auth\Authenticatable as Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class User extends Model implements Authenticatable
{
    use Auth;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role',  'active','provider_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
   protected $casts = [
       'email_verified_at' => 'datetime',
   ];



    // RELATIONS

    public function annoncer() {
        return $this->hasOne(Annoncer::class);
    }
    public function admin() {
        return $this->hasOne('App\Admin');
    }
}
