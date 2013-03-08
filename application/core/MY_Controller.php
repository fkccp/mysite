<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->init();
	}

	private function init()
	{

	}

	private $pageinfo = array(
		'csses' => array(),
		'jses' => array(),
		'title' => '',
		'bc' => ''
	);

	protected function add_css($css, $is_abso = false)
	{
		if(!$is_abso)
			$css = '/static/css/' . $css;
		$this->pageinfo['csses'][] = $css;
	}

	protected function add_js($js, $is_abso = false)
	{
		if(!$is_abso)
			$js = '/static/js/' . $js;
		$this->pageinfo['jses'][] = $js;
	}

	protected function set_title($title)
	{
		$this->pageinfo['title'] = $title;
	}

	protected function set_bc($bc)
	{
		$strbc = '<div id="bc">';
		$strbc .= '<a href="/bbs">首页</a>';
		foreach ($bc as $k => $v) {
			if($v)
				$strbc .= ' >> <a href="'.$v.'">'.$k.'</a>';
			else
				$strbc .= ' >> ' . $k;
		}

		$strbc .= "</div>";
		$this->pageinfo['bc'] = $strbc;
	}

	protected function v($tpl, $args = array())
	{
		$this->set_header();
		$args['bc'] = $this->pageinfo['bc'];
		$this->pageinfo['body'] = $this->load->view($tpl, $args, true);
		$this->load->view('page', $this->pageinfo);
	}

	private function set_header()
	{
		$this->pageinfo['header'] = $this->load->view('header', array(), true);
	}
}

/* eof */