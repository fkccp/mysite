<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bbs extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->node();
	}

	public function node($node = '')
	{
		$this->set_title('首页');
		$args['name'] = 'xiaojing';
		$args['sidebar'] = $this->sidebar();
		$this->v('bbs/index', $args);
	}

	public function add($node='')
	{
		$bc = array();
		if($node)
			$bc[$node] = '';
		
		$this->set_bc($bc);

		$this->v('bbs/add', array('sidebar'=>$this->sidebar()));
	}

	private function sidebar($uid = 0)
	{
		return $this->load->view('bbs/sidebar', null, true);
	}
}

/* eof */