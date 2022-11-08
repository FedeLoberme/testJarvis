<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Group_IP extends Model
{
    protected $table = 'group_ip';
    protected $fillable = [
        'name',
    ];
}
