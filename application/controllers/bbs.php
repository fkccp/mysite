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

	public function node($nodename = '')
	{
		$this->set_title('首页');

		$this->load->model('bbsmodel', 'bbs');
		$bc = array('bbs'=>'/index.php/bbs');
		if($nodename)
		{
			$nodename = urldecode($nodename);
			$nid = db_result('bbs_node', 'id', array('name'=>$nodename));
			if(false === $nid) $this->err_404();
			$bc[$nodename] = '/index.php/bbs/node/' . $nodename;
		}
		else
			$nid = 0;

		$args['list'] = $this->bbs->get_list($nid);
		if(false === $args['list']) $this->err_404();
		$this->set_bc($bc);

		$args['pager'] = gen_pager(Sget('n_bbs_post', 0));

		$args['sidebar'] = $this->sidebar();
		$args['nodename'] = htmlspecialchars($nodename);

		$this->v('bbs/index', $args);
	}

	public function post($id)
	{
		$id = abs(intval($id));

		$this->load->model('bbsmodel', 'bbs');
		$args = $this->bbs->get_post($id);
		if(false === $args) $this->err_404();

		inc('bbs_post', 'n_click', array('id'=>$id));
		$args['sidebar'] = $this->sidebar();

		$bc = array(
			'bbs' => '/index.php',
			$args['nodename'] => '/index.php/bbs/node/' . $args['nodename'],
			$args['title'] => ''
		);

		$this->set_bc($bc);

		$this->load->model('cmtmodel', 'cmt');
		$args['cmts'] = $this->cmt->get_list('bbs', $id);

		$this->v('bbs/post', $args);
	}

	public function add($node='')
	{
		$bc = array();
		if($node)
			$bc[$node] = '';
		
		$this->set_bc($bc);

		$args = array('sidebar'=>'');
		$args['node'] = $node;

		$this->v('bbs/add', $args);
	}

	public function ajax_add()
	{
		$post = $this->input->post();
		$node_name = htmlspecialchars($post['node']);
		$nid = db_result('bbs_node', 'id', array('name'=>$node_name));
		if(false == $nid)
		{
			$re = $this->db->insert('bbs_node', array('name'=>$node_name));
			$nid = $this->db->insert_id();
			
		}
		
		$data = array(
			'nid' => $nid,
			'title' => htmlspecialchars($post['title']),
			'content' => pro_editor_content($post['content']),
			'uid' => $this->u['id'],
			'ctime' => time()
		);

		inc('bbs_node', 'n_post', array('id'=>$nid));
		Sinc('n_bbs_post');
		$this->db->insert('bbs_post', $data);
		
		echo $this->db->insert_id();
	}

	private function sidebar($uid = 0)
	{
		return $this->load->view('bbs/sidebar', null, true);
	}
}

/* eof */