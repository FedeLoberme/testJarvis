<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profile extends Model
{
	protected $table = 'profile';
    protected $fillable = [
        'name',
    ];
    protected $dates = ['deleted_at'];


    public function permissions($id_application){
	    return $this->hasMany(Permissions::class, 'id_profile')->where('id_application', $id_application)->first();

	}

	public function user(){
	    return $this->hasMany('Jarvis\User','id_profile', 'id');
	}
}
