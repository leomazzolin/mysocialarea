<?php
class Class_Overload1
{
	protected $_data = array();
	
	public function __get( $key )
	{
		if(array_key_exists( $key, $this->_data))
		{
			return $this->_data[$key];
		}
		else
		{
			return NULL;
		}
	}
	
	public function __set($key, $val)
	{
		$this->_data[$key] = $val;
	}

}
?>

