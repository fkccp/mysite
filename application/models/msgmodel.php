<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msgmodel extends CI_Model
{
	public function get_num($has_read = 3)
	{
		if(in_array($has_read, array(0, 1)))
			$this->db->where('has_read', $has_read);
		return $this->db->where('ruid', $this->u['id'])->count_all_results('bbs_notice');
	}

	public function get_list()
	{
		$uid = $this->u['id'];

		$page = intval($this->input->get('page'));
		if(0 == $page) $page = 1;

		return $this->db
			->select('n.*, u.name, p.title')
			->join('user u', 'u.id=n.suid')
			->join('bbs_post p', 'p.id=n.pid')
			->where('n.ruid', $uid)
			->order_by('n.has_read')
			->order_by('n.ctime', 'desc')
			->limit(25, ($page-1)*25)
			->get('bbs_notice n')
			->result_array();
	}
}

/* eof */