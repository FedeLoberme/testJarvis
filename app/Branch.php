<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
    protected $fillable = [ 'name', 'description', 'rank', 'id_branch', 'type_ip', 'ip_rank', 'prefixes_rank',];
}