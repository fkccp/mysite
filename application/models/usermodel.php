<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model
{
	public function get_user_info($column, $val)
	{
		$this->db->join('userinfo i', 'i.uid=u.id', 'left');
		return db_result('user u', 'id, name, nickname', array($column=>$val));
	}
}

/* eof */