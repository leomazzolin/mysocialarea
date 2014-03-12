<?php

//include "facebook_library/facebook.php";

class Model_Facebook
{
	protected $_fb = array();
	
	function __construct()
	{
   		$config = Zend_Registry::get("appOptions");
		$this->_fb['app_id'] = $config['my']['facebook']['app_id'];
		$this->_fb['api_key'] = $config['my']['facebook']['api_key'];
		$this->_fb['secret'] = $config['my']['facebook']['secret'];
		$this->_fb['channel'] = $config['my']['facebook']['channel'];
	}
	
	public function _getData($string)
	{
		switch ($string)
		{
			case 'app_id':
				return $this->_fb['app_id'];
			case 'api_key':
				return $this->_fb['api_key'];
			case 'secret':
				return $this->_fb['secret'];
			case 'channel':
				return $this->_fb['channel'];
			default:
				return NULL;
		}
	}
	
	public function _sdkSetUp()
	{
		$data = new stdClass();
		$data->_app_id = $this->_fb['app_id'];
		$data->_channel = $this->_fb['channel'];
		return $data;
	}

	public function _isValidFacebookSession($data)
	{
		$signature = md5( "expires=" . $data->_expires . "session_key=" . $data->_session_key . "ss=" . $data->ss . "user=" . $data->_user . $data->_secret);
		return ($signature == $data->_valid_signature ? true : false);
	}
	
}

?>