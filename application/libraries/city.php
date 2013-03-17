<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City
{
	public function __construct($value='')
	{
		$this->ci = &get_instance();
	}

	public function get_states()
	{
		return $this->ci->db->select('sid,name')->where('cid', 0)->get('site_city')->result_array();		
	}

	public function get_list($ids)
	{
		$cols = array('sid', 'cid', 'rid', 'tid');
		$where = array();

		foreach ($cols as $k=>$v)
		{
			if($k!=count($ids))
				$where[$v] = 0;
		}
		$where[$cols[count($ids)] . ' !='] = 0;
		foreach ($ids as $k=>$v)
		{
			$where[$cols[0]] = $v;
			array_shift($cols);
		}

		$re = $this->ci->db->select($cols[0] . ' as id,name')->where($where)->get('site_city')->result_array();

		$data = array();
		foreach ($re as $v)
		{
			$data[$v['id']] = $v['name'];
		}

		return $data;
	}

	public function xlate($id)
	{
		$re = $where = array();
		$cols = array('sid', 'cid', 'rid', 'tid');
		for($i=0; $i < 4; $i++)
		{
			$where[$cols[$i]] = 0;
		}

		$cache = array();
		$len = strlen($id) / 2;

		for ($i=0; $i < $len; $i++)
		{ 
			$where[$cols[$i]] = substr($id, $i*2, 2);
			$re[] = db_result('site_city', 'name', $where);
		}

		return $re;
	}

	public function format()
	{
		$x = simplexml_load_file(dirname(APPPATH) . '/LocList.xml');

		$sid = 11;
		foreach ($x->State as $v)
		{
			$name = $this->get_name($v);
			$this->ins($name, $sid);
			$cid = 11;
			foreach ($v->City as $v2)
			{
				$name = $this->get_name($v2);
				$this->ins($name, $sid, $cid);
				if($v2->Region)
				{
					$rid = 11;
					foreach ($v2->Region as $v3)
					{
						$name = $this->get_name($v3);
						$this->ins($name, $sid, $cid, $rid);
						if($v3->Town)
						{
							$tid = 11;
							foreach ($v3 as $v4)
							{
								$name = $this->get_name($v4);
								$this->ins($name, $sid, $cid, $rid, $tid);
								$tid++;
							}
						}
						$rid++;
					}
				}
				$cid++;
			}
			$sid++;
		}


		// print_r($x);
	}

	private function get_name($o)
	{
		$o = $o->attributes();
		$o = (array) $o;
		return $o['@attributes']['Name'];
	}

	private function ins($name, $sid, $cid = 0, $rid = 0, $tid = 0)
	{
		// var_dump($name . $sid . $cid . $rid . $tid);
		$this->ci->db->insert('site_city', array('sid'=>$sid, 'cid'=>$cid, 'rid'=>$rid, 'tid'=>$tid, 'name'=>$name));
	}
}

/* eof */