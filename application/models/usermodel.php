<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermodel extends CI_Model
{
	public function get_user_info($column, $val)
	{
		$this->db->join('userinfo i', 'i.uid=u.id', 'left');
		return db_result('user u', '*', array($column=>$val));
	}

	public function save($data)
	{
		if(!$data['from_id']) unset($data['from_id']);
		if(!$data['live_id']) unset($data['live_id']);
		if(!$data['birth']) unset($data['birth']);

		$this->db->where('uid', $this->u['id'])->update('userinfo', $data);
	}
}

/* eof */