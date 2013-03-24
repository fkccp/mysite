<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usermodel', 'user');
	}

	public function index($uid)
	{
		$args = $this->user->get_user_info('id', $uid);
		if(false == $args) $this->err_404();

		// print_r($args);
		$bc = array($args['name'] . '的个人信息'=>'');
		$this->set_bc($bc);

		$args['sex'] = $args['sex_pub'] ? ((1 == $args['sex']) ? '男' : '女') : '非公开';
		$args['birth'] = $args['birth_pub'] ? $args['birth'] : '非公开';
		$this->load->library('city');
		$args['from'] = join($this->city->xlate($args['from_id']), ' ');
		$args['live'] = join($this->city->xlate($args['live_id']), ' ');

		if($args['married_pub'])
		{
			$married_map = array(1=>'单身', 2=>'热恋中', 3=>'已婚');
			$args['married'] = $married_map[$args['married']];
		}
		else
			$args['married'] = '非公开';

		if($args['n_bbs_post'])
		{
			$this->load->model('bbsmodel', 'bbs');
			$args['bbs_posts'] = $this->bbs->get_user_list($uid);
		}

		if($args['n_bbs_cmt'])
		{
			$this->load->model('cmtmodel', 'cmt');
			$args['bbs_cmts'] = $this->cmt->get_user_list('bbs', $uid);
		}

		$this->v('user/info', $args);
	}

	public function setting()
	{
		$user = $this->u;
		$post = $this->input->post();

		if($post)
		{
			header('Location: /user/' . $user['id']);
			$married_map = array('s'=>1, 'l'=>2, 'm'=>3);
			$data = array();
			$data['sex'] = ('w' == arr_get($post, 'sex', 'w')) ? 0 : 1;
			$data['sex_pub'] = ('off' == arr_get($post, 'sex_pub', 'off')) ? 1 : 0;
			$data['birth'] = intval(arr_get($post, 'birth'));
			$data['birth_pub'] = ('off' == arr_get($post, 'birth_pub', 'off')) ? 1 : 0;
			$data['from_id'] = intval(arr_get($post, 'from_id', 0));
			$data['live_id'] = intval(arr_get($post, 'live_id', 0));
			$data['married'] = arr_get($married_map, arr_get($post, 'ma', 's'));
			$data['married_pub'] = ('off' == arr_get($post, 'ma_pub', 'off')) ? 1 : 0;
			$data['job'] = htmlspecialchars(arr_get($post, 'job'));
			$data['sign'] = htmlspecialchars(arr_get($post, 'sign'));

			$this->user->save($data);
			$this->over();
		}

		$args = $this->user->get_user_info('id', $this->u['id']);
		$this->load->library('city');
		$args['from'] = join($this->city->xlate($args['from_id']), ' ');
		$args['live'] = join($this->city->xlate($args['live_id']), ' ');

		// print_r($args);

		$bc = array(
			'个人中心' => '/user/' . $user['id'],
			'个人设置' => ''
		);
		$this->set_bc($bc);

		$this->load->library('city');
		$args['states'] = $this->city->get_states();

		$this->v('user/setting', $args);
	}

	// function x()
	// {
	// 	$this->load->library('city');
	// 	$this->city->format();
	// }
}

/* eof */