<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msg extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->set_bc(array('提醒'=>''));

		if('true' == $this->input->get('readall'))
		{
			$this->db->set('has_read', 1)->where('ruid', $this->u['id'])->update('bbs_notice');
			header('Location: /msg');
			$this->over();
		}

		$args = array();

		$args['list'] = $this->msg->get_list();
		$args['pager'] = gen_pager($this->msg->get_num());


		$this->v('msg/index', $args);
	}
}

/* eof */