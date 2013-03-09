<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function arr_get($arr, $k)
{
	return $arr[$k];
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