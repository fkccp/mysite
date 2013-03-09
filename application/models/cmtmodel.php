<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmtmodel extends CI_Model
{
	public function get_list($type = 'bbs', $id)
	{
		$args = array();

		$args['list'] = array('aaa');
		return $this->load->view('cmt/list', $args, true);
	}
}

/* eof */