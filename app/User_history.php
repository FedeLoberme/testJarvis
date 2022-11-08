<?php
namespace Jarvis;
use DB;
use Illuminate\Database\Eloquent\Model;
class User_history extends Model
{
    protected $table = 'user_history';
    protected $fillable = [
        'id_user',
        'description',
    ];

    public function user(){
    	return $this->belongsTo('Jarvis\User', 'id_user', 'id');
    }
}
