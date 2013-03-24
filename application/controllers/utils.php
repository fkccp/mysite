<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->u === null) $this->err_404();
	}

	public function bbs_cmt_add()
	{
		$cnt = $this->input->post('cnt');
		$cmtid = intval($this->input->post('cmtid'));

		$filters = array(
			'#<style>(.*)</style>#i',
			'#<object>(.*)</object>#i',
			'#<frame>(.*)</frame>#i',
			'#<iframe>(.*)</iframe>#i',
			'#<blockquote>(.*)</blockquote>#i',
			'#<script>(.*)</script>#i'
		);
		// strip_tags ???
		$cnt = preg_replace($filters, '', $cnt);

		$cmtid = intval($this->input->post('cmtid'));
		$ref = arr_get($_SERVER, 'HTTP_REFERER');
		if('' == $cnt || false === $ref || 0 == preg_match('#bbs/post/(\d+)#', $ref, $m))
		{
			echo 'e';
			return false;
		}

		if($cmtid)
		{
			$this->db->join('user u', 'u.id=c.uid');
			$scmt_data = db_result('bbs_cmt c', 'content,uid,name', array('c.id'=>$cmtid));
			$scmt_data['content'] = '<p class="name"><a href="#cmt_'.$cmtid.'">'.$scmt_data['name'].' : </a></p>' . preg_replace('#<blockquote>(.*)</blockquote>#i', '', $scmt_data['content']);
			$cnt = sprintf('<blockquote>%s</blockquote>', $scmt_data['content']) . $cnt;
		}

		$data = array(
			'pid' => $m[1],
			'uid' => $this->u['id'],
			'content' => $cnt,
			'ctime' => time()
		);

		$this->db->insert('bbs_cmt', $data);
		$cmt_id = $this->db->insert_id();

		// 回复 站内信
		$notice_data = array(
			'suid' => $this->u['id'],
			'pid' => $m[1],
			'ctime' => time()
		);

		if($cmtid)
		{
			$notice_data['ruid'] = $scmt_data['uid'];
			$notice_data['cid'] = $cmt_id;
			if($notice_data['ruid'] != $notice_data['suid']) $this->db->insert('bbs_notice', $notice_data);
		}
		
		$notice_data['ruid'] = db_result('bbs_post', 'uid', array('id'=>$m[1]));
		$notice_data['cid'] = 0;
		if($notice_data['ruid'] != $notice_data['suid'] &&
			$notice_data['ruid'] != $scmt_data['uid']) 
			$this->db->insert('bbs_notice', $notice_data);



		$this->db
			->set('n_cmt', 'n_cmt+1', false)
			->set('last_cmt_ctime', time())
			->set('last_cmt_username', $this->u['name'])
			->set('last_cmt_userid', $this->u['id'])
			->where('id', $m[1])
			->update('bbs_post');

		inc('userinfo', 'n_bbs_cmt', array('uid'=>$this->u['id']));

		echo $cmt_id;
	}

	public function action()
	{
		$post = $this->input->post();
		$type = arr_get($post, 'type');
		$model = arr_get($post, 'model');
		$id = intval(arr_get($post, 'id', 0));
		$act = 1 - intval(arr_get($post, 'action')); // 
		$user = $this->u;

		if(in_array($type, array('like', 'mark'))
			&& in_array($model, array('bbs', 'cmt'))
			&& $id > 0)
		{

			if('cmt' == $post['model'] && 'like' == $type)
			{
				$ref = arr_get($_SERVER, 'HTTP_REFERER');
				if(preg_match('#bbs#', $ref))
					$cmt_type = 'bbs';
				else
					return false;

				$table = $cmt_type . '_cmt_like';
				$db_act = intval(db_result($table, 'uid', array('cid'=>$id)));
				if($db_act > 0 && 0 == $act)
				{
					$this->db->where(array('cid'=>$id, 'uid'=>$user['id']))->delete($table);
					inc($cmt_type . '_cmt', 'n_like', array('id'=>$id), -1);
				}
				elseif(0 == $db_act && 1 == $act)
				{
					$this->db->insert($table, array('cid'=>$id, 'uid'=>$user['id'], 'ctime'=>time()));
					inc($cmt_type . '_cmt', 'n_like', array('id'=>$id));
				}
			}
			else
			{
				$table = $model . '_' . $type;
				$db_act = intval(db_result($table, 'uid', array('pid'=>$id)));
				if($db_act > 0 && 0 == $act)
				{
					$this->db->where(array('pid'=>$id, 'uid'=>$user['id']))->delete($table);
					inc($model . '_post', 'n_' . $type, array('id'=>$id), -1);
					if('mark' == $type)
					{
						inc('userinfo', 'n_' . $model . '_mark', array('uid'=>$user['id']), -1);
					}
				}
				elseif(0 == $db_act && 1 == $act)
				{
					$this->db->insert($table, array('pid'=>$id, 'uid'=>$user['id'], 'ctime'=>time()));
					inc($model . '_post', 'n_' . $type, array('id'=>$id));
					if('mark' == $type)
					{
						inc('userinfo', 'n_' . $model . '_mark', array('uid'=>$user['id']));
					}
				}
			}
		}
	}

	public function city()
	{
		$data = $this->input->get();
		if($data)
		{
			$ids = array_slice($data['ids'], 0, $data['index']+1);
			$this->load->library('city');
			$cities = $this->city->get_list($ids);
			echo json_encode($cities);
		}
	}
}

/* eof */