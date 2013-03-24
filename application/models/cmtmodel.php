<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmtmodel extends CI_Model
{
	// 提取某帖评论
	public function get_list($type = 'bbs', $id)
	{
		$args = array();

		$args['total'] = db_result($type . '_post', 'n_cmt', array('id'=>$id));

		$args['list'] =
			$this->db
				->select('u.name, c.id, c.uid, c.content, c.ctime, c.n_like, l.uid as has_like')
				->join('user u', 'u.id=c.uid')
				->join($type . '_cmt_like l', 'l.cid=c.id AND l.uid=' . $this->u['id'], 'left')
				->where('c.is_show', 1)
				->where('c.pid', $id)
				->order_by('c.ctime', 'asc')
				->get($type . '_cmt c')
				->result_array();

		return $this->load->view('cmt/list', $args, true);
	}

	// 提取某用户评论
	public function get_user_list($type, $uid)
	{
		return $this->db
			->select('c.id, c.content, c.ctime, c.pid, p.title')
			->join($type . '_post p', 'c.pid=p.id AND p.is_show = 1')
			->where(array('c.uid'=>$uid, 'p.is_show'=>1, 'c.is_show'=>1))
			->order_by('c.ctime', 'desc')
			->limit(5)
			->get($type . '_cmt c')
			->result_array();
	}
}

/* eof */