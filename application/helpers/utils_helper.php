<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function arr_get($arr, $k, $default = false)
{
	if(!is_array($arr)) return $default;

	if(array_key_exists($k, $arr))
		return $arr[$k];
	else
		return $default;
}

function db_result($table, $columns, $where)
{
	$ci = &get_instance();
	$data = $ci->db->select($columns)->where($where)->limit(1)->get($table)->result_array();
	if(0 == count($data)) return false;

	if('*' != $columns && false === strpos($columns, ','))
		return $data[0][$columns];
	else
		return $data[0];
}

function inc($table, $column, $where, $step = 1)
{
	$ci = &get_instance();
	$ci->db->set($column, $column . ' + ' . $step, false)->where($where)->update($table);
	return $ci->db->affected_rows();
}

function pro_editor_content($str)
{
	return $str;
}

function beautify_time ($time)
{
	$now = time();
	$delta = $now - $time;

	if($delta >= 86400)
		return floor($delta / 86400) . '天';
	elseif ($delta > 3600)
		return floor($delta / 3600) . '小时';
	elseif ($delta > 1800)
		return '半小时';
	elseif($delta >= 60)
		return floor($delta / 60) . '分钟';
	else
		return $delta . '秒';
}

function gen_pager($total)
{
	$ci = &get_instance();
	$ci->load->library('pagination');

	$url = arr_get($_SERVER, 'REQUEST_URI');
	if(false == strpos($url, '?'))
		$url .= '?';
	else
	{
		$url = preg_replace('/page=(.*?)(&|$)/', '', $url);
		$url = trim($url, '&');
	}

	$config['base_url'] = $url;
	$config['total_rows'] = $total;
	$config['per_page'] = 25;
	$config['page_query_string'] = TRUE;
	$config['use_page_numbers'] = TRUE;
	$config['query_string_segment'] = 'page';

	$ci->pagination->initialize($config);
	$pager = $ci->pagination->create_links();
	return preg_replace(array('/\?&amp;/', '/&amp;page=1?"/', '/\?page=1?"/'), array('?', '"', '"'), $pager);
}

function cmt_seainfo($n)
{
	return '';
	$str = '这位小盆友在';
	if(1 == $n)
		$str .= '神农顶上仰望星空，思考着下一顿吃什么';
	elseif($n < 34)
		$str .= '海拔' . (3400 - $n*100) . '米的地方被野人赶来赶去';
	elseif(34 == $n)
		$str .= '海面上悠哉地漂来漂去';
	else
		$str .= '海下' . ($n*100 - 3400) . '米的地方被鲨鱼追来追去';

	$str .= '...';
	return $str;
}

function pro_like($type, $id)
{
	$ci = &get_instance();
	$re = array();
	$inc = true;
	$uid = $ci->u['id'];

	foreach (array('like', 'mark') as $action)
	{
		$act = $ci->input->get($action);
		$table = $type . '_' . $action;
		$db_act = db_result($table, 'uid', array('uid'=>$uid, 'pid'=>$id));
		$db_act = (false === $db_act) ? 0 : 1;
		$add = 0;

		if(in_array($act, array('y', 'n')))
		{
			if('y' == $act && 0 == $db_act)
			{
				$ci->db->insert($table, array('pid'=>$id, 'uid'=>$uid, 'ctime'=>time()));
				inc($type . '_post', 'n_' . $action, array('id'=>$id));
				$add = 1;
				$db_act = 1;
			}
			elseif('n' == $act && 1 == $db_act)
			{
				$ci->db->where(array('pid'=>$id, 'uid'=>$uid))->delete($table);
				inc($type . '_post', 'n_' . $action, array('id'=>$id), -1);
				$add = -1;
				$db_act = 0;
			}
			$inc = false;
		}
		$re[$action] = $db_act;
		$re[$action . '_add'] = $add;
	}

	if($inc) inc($type . '_post', 'n_click', array('id'=>$id));
	
	return $re;
}

function Sset($k, $v)
{
	$ci = &get_instance();
	$ci->db->replace('site_setting', array('k'=>$k, 'v'=>$v));
}

function Sget($k, $default = '')
{
	$re = db_result('site_setting', 'v', array('k'=>$k));
	if(false === $re) return $default;
	return $re;
}

function Sinc($k, $step = 1)
{
	$affected_rows = inc('site_setting', 'v', array('k'=>$k), $step);
	if(0 == $affected_rows) Sset($k, $step);
}

/* eof */