<?php 
class Class_Initcontroller
{
	protected $_uri = NULL;
	protected $_params = array();	
	
	function __construct($uri = NULL, $params = NULL)
	{
		if($uri != NULL)
		{
			$this->_setURI($uri);
		}
		if($params != NULL)
		{
			$this->_setParams($params);
		}
	}
	
	public function _setURI($uri)
	{
		$this->_uri = $this->_cleanURI($uri);
	}

	public function _setParams($params)
	{
		$this->_params = $this->_cleanParams($params);
	}
	
	public function _getURI()
	{
		return $this->_uri;
	}

	public function _getParams()
	{
		return $this->_params;
	}
	
	protected function _cleanURI($uri)
	{
		return strip_tags(trim($uri));
	}

	protected function _cleanParams($params)
	{
		$p = array();
		foreach($params as $key => $value)
		{
			if(is_string($value)){
				$p[$key] = str_replace( ' ', '', strip_tags(trim($value)));
			}
		}
		return $p;
	}

}
?>