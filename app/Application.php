<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;

class Application extends Model
{
    protected $table = 'application';
    protected $fillable = [
        'name',
    ];

    public function permissions()
	{
	    return $this->hasMany('Jarvis\Permissions','id_application', 'id');
	}
}
