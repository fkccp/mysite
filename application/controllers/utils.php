<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils extends My_Controller
{
	public function bbs_cmt_add()
	{
		$cnt = $this->input->post('cnt');
		$ref = arr_get($_SERVER, 'HTTP_REFERER');
		if('' == $cnt || false === $ref || 0 == preg_match('#bbs/post/(\d+)#', $ref, $m))
		{
			echo 'e';
			return false;
		}

		$data = array(
			'pid' => $m[1],
			'uid' => $this->u['id'],
			'content' => $cnt,
			'ctime' => time()
		);

		$this->db->insert('bbs_cmt', $data);
		$cmt_id = $this->db->insert_id();

		$this->db
			->set('n_cmt', 'n_cmt+1', false)
			->set('last_cmt_ctime', time())
			->set('last_cmt_username', $this->u['name'])
			->set('last_cmt_userid', $this->u['id'])
			->where('id', $m[1])
			->update('bbs_post');

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
				}
				elseif(0 == $db_act && 1 == $act)
				{
					$this->db->insert($table, array('pid'=>$id, 'uid'=>$user['id'], 'ctime'=>time()));
					inc($model . '_post', 'n_' . $type, array('id'=>$id));
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