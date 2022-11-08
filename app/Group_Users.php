<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Group_Users extends Model
{
    protected $table = 'group_users';
    protected $fillable = [
        'id_group_ip',
        'id_user',
    ];
}
