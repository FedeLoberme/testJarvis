<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Permissions_IP extends Model
{
    protected $table = 'permissions_ip';
    protected $fillable = ['id_group_ip', 'id_user', 'id_branch', 'permissions',];
}
