<?php
namespace Jarvis;
use Illuminate\Database\Eloquent\Model;
use DB;
class Node extends Model
{
    protected $table = 'node';
    protected $fillable = ['cell_id', 'node', 'address', 'contract_date', 'type', 'owner', 'commentary', 'status'];
}
