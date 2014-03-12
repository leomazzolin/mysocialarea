<?php
class Model_My_Utility
{
	public function dump($data)
	{
		echo '<br clear="all" />';
		echo '<pre>';
		var_dump($data);
		echo '</pre>';
	}
	
	public function _cleanParams($p)
	{
		$params = array();
		foreach($p as $key => $value)
		{
			$params[$key] = str_replace( ' ', '', strip_tags(trim($value)));
		}
		return $params;
	}

	public function _cleanUri($uri)
	{
		return strip_tags(trim($uri));
	}

	public function _setReturnUri($data)
	{
		
		if(stristr($data->_defaultUri . '/uri', $data->_uri) == 0 && substr_count($data->_uri, $data->_defaultUri) == 1 )
		{
			$returnUri = str_replace($data->_defaultUri . '/uri/',"",$data->_uri);
			return $returnUri;
		}
		else
		{
			return '/default/index/index';
		}
	}

///////////////////////////////////////////////////

	public function row_count($rows)
	{
		if($rows == NULL)
		{
			return 0;
		}
		else
		{
			return $rows->count();
		}
	}
	
	public function get_part_of_now($x)
	{
		$now = new Zend_Date();
		switch ($x)
		{
		case 'year':
			return $now->get(Zend_Date::YEAR);
			break;
		case 'month':
			return $now->get(Zend_Date::MONTH);
			break;
		case 'month':
			return $now->get(Zend_Date::DAY);
			break;
		case 'date_now':
		  	return $now->get(Zend_Date::YEAR) . '-' . $now->get(Zend_Date::MONTH) . '-' . $now->get(Zend_Date::DAY);
			break;			
		case 'time_now':
			return $now->get(Zend_Date::TIMES);
			break;
		default:
			return NULL;
		  	break;
		}
	}

	public function date_conv_1($x)
	{
		$date = new Zend_Date();
		$date->set($x);
		return $date->get(Zend_Date::YEAR) . '-' . $date->get(Zend_Date::MONTH) . '-' . $date->get(Zend_Date::DAY);
	}

	public function add_a_day($x)
	{
		$date = new Zend_Date();
		$date->set($x, Zend_Date::ISO_8601);
		$date->add('1', Zend_Date::DAY);
		return $date->get(Zend_Date::YEAR) . '-' . $date->get(Zend_Date::MONTH) . '-' . $date->get(Zend_Date::DAY);
	}

	public function add_x_days($data)
	{
		$date = new Zend_Date();
		$date->set($data->_date, Zend_Date::ISO_8601);
		$date->add($data->days, Zend_Date::DAY);
		return $date->get(Zend_Date::YEAR) . '-' . $date->get(Zend_Date::MONTH) . '-' . $date->get(Zend_Date::DAY);
	}

	public function minus_a_day($x)
	{
		$date = new Zend_Date();
		$date->set($x, Zend_Date::ISO_8601);
		$date->sub('1', Zend_Date::DAY);
		return $date->get(Zend_Date::YEAR) . '-' . $date->get(Zend_Date::MONTH) . '-' . $date->get(Zend_Date::DAY);
	}

}
?>