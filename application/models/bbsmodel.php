<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bbsmodel extends CI_Model
{
	// 帖子内容
	public function get_post($id)
	{
		$data = db_result('bbs_post', '*', array('id'=>$id));
		if(false === $data) return false;
		$data['username'] = db_result('user', 'name', array('id'=>$data['uid']));
		$data['nodename'] = db_result('bbs_node', 'name', array('id'=>$data['nid']));

		$data['appends'] = $this->db
							->select('content, ctime')
							->where('pid', $id)
							->order_by('id', 'asc')
							->get('bbs_append')
							->result_array();
		return $data;
	}

	// 根据结点id提取帖子列表
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

	// 根据用户uid提取帖子列表
	public function get_user_list($uid)
	{
		return $this->db
			->select('id, title, ctime')
			->where(array('uid'=>$uid, 'is_show'=>1))
			->order_by('ctime', 'desc')
			->limit(5)
			->get('bbs_post')
			->result_array();
	}
}

/* eof */