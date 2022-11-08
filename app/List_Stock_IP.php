<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Stock_IP extends Model
{
	protected $table = 'list_stock_ip';
    protected $fillable = ['rank','status','use',];
}
