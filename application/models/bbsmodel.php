<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bbsmodel extends CI_Model
{
	public function get_post($id)
	{
		$data = db_result('bbs_post', '*', array('id'=>$id));
		if(false === $data) return false;
		$data['username'] = db_result('user', 'name', array('id'=>$data['uid']));
		$data['nodename'] = db_result('bbs_node', 'name', array('id'=>$data['nid']));
		return $data;
	}

	public function get_list($nid)
	{
		$page = abs(intval($this->input->get('page')));
		if($page >= 1) $page--;

		if($nid) $this->db->where('nid', $nid);
		$list = $this->db
				->select('u.name, p.id, p.uid, p.title, p.ctime')
				->join('user u', 'u.id=p.uid')
				->order_by('p.ctime', 'desc')
				->where('p.is_show', 1)
				->limit(25, $page * 25)
				->get('bbs_post p')
				->result_array();

		return $list;
	}
}

/* eof */