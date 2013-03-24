<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends MY_Controller
{
	public function index()
	{
		$this->set_bc(array('帮助中心'=>''));
		$this->v('help/index');
	}

	public function about()
	{
		$this->set_bc(array('关于网站'=>''));
		$this->v('help/about');
	}
}

/* eof */