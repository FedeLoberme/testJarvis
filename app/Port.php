<?php

namespace Jarvis;
use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

class Port extends Model
{
    protected $table = 'port';
    protected $fillable = ['id_board', 'n_port', 'id_status',  'commentary', 'connected_to', 'type',  'id_uplink', 'id_ring', 'id_lacp_port', 'id_chain', 'id_odu', 'id_antena'];

    public static function get_id($board_id, $port_n, $status_id = 2, $type = null){
		try {
			$port = DB::table("port")
				->where('id_board', $board_id)
				->where('n_port', $port_n)
				->select('id')->first();
			if (!empty($port)) {
				$id = $port->id;
			} else {
				$port_new = new Port();
				$port_new->id_board = $board_id;
				$port_new->n_port = $port_n;
				$port_new->id_status = $status_id;
				$port_new->type = $type;
				$port_new->save();
				$id = $port_new->id;
			}
			return $id;
		} catch (Exception $e) {
			return $e->getMessage();
		}
    }
}