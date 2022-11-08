<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Record_ip extends Model
{
    protected $table = 'record_ip';
    protected $fillable=[ 'id_ip', 'prefixes', 'attribute', 'id_user'];
}