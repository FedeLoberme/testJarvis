<?php
namespace Jarvis;
use Illuminate\Database\Eloquent\Model;
use DB;
class Permissions extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'id_profile',
        'id_application',
        'permission',
    ];

    public function application(){
    return $this->belongsTo('Jarvis\Application', 'id_application', 'id');
	}

	public function profile(){
    return $this->belongsTo('Jarvis\Profile', 'id_profile', 'id');
	}
}
