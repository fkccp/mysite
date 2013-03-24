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
		$bc = array('bbs'=>'/bbs');
		if($nodename)
		{
			$nodename = urldecode($nodename);
			$nid = db_result('bbs_node', 'id', array('name'=>$nodename));
			if(false === $nid) $this->err_404();
			$bc[$nodename] = '/bbs/node/' . $nodename;
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

		$args['sidebar'] = $this->sidebar($args['uid']);

		$args['has_like'] = intval(db_result('bbs_like', 'uid', array('pid'=>$id, 'uid'=>$this->u['id'])));
		$args['has_mark'] = intval(db_result('bbs_mark', 'uid', array('pid'=>$id, 'uid'=>$this->u['id'])));

		$bc = array(
			'bbs' => '/bbs',
			$args['nodename'] => '/bbs/node/' . $args['nodename'],
			$args['title'] => ''
		);

		$this->set_bc($bc);

		$this->load->model('cmtmodel', 'cmt');
		$args['cmts'] = $this->cmt->get_list('bbs', $id);

		$args['is_my_post'] = $args['uid'] == $this->u['id'];

		$this->v('bbs/post', $args);
	}

	public function append($id)
	{
		$this->load->model('bbsmodel');
		$info = db_result('bbs_post', 'id,title,nid,uid', array('id'=>$id, 'is_show'=>1));
		if(false === $info) $this->err_404();
		if($info['uid'] != $this->u['id'])
		{
			header('Location: /bbs/post/' . $id);
			$this->over();
		}
		$nodename = db_result('bbs_node', 'name', array('id'=>$info['nid']));

		$bc = array(
			'bbs' => '/bbs',
			$nodename => '/bbs/node/' . $nodename,
			$info['title'] => '/bbs/post/' . $id,
			'添加附言' => ''
		);
		$this->set_bc($bc);
		
		$this->v('bbs/append');
	}

	public function ajax_append()
	{
		$cnt = $this->input->post('cnt');
		$ref = arr_get($_SERVER, 'HTTP_REFERER');
		if('' == $cnt || false === $ref || 0 == preg_match('#bbs/append/(\d+)#', $ref, $m))
		{
			echo 'e';
			return false;
		}

		$data = array(
			'pid' => $m[1],
			'content' => $cnt,
			'ctime' => time()
		);
		$this->db->insert('bbs_append', $data);

		echo $m[1];
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
		inc('userinfo', 'n_bbs_post', array('uid'=>$this->u['id']));
		Sinc('n_bbs_post');
		$this->db->insert('bbs_post', $data);

		echo $this->db->insert_id();
	}

	private function sidebar($uid = 0)
	{
		$args = array();
		if(0 == $uid)
			$user = $this->u;
		else
			$user = $this->user->get_user_info('id', $uid);
		$args['user'] = $user;

		return $this->load->view('bbs/sidebar', $args, true);
	}
}

/* eof */