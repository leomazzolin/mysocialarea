<?php
include( APPLICATION_PATH . '/classes/recaptchalib.php' );

class Model_Recaptcha
{
	protected $_data = array();
	
	function __construct()
	{
   		$config = Zend_Registry::get("appOptions");
		$this->_data['privateKey'] = $config['my']['captcha']['privatekey'];
		$this->_data['publicKey'] =  $config['my']['captcha']['publickey'];
	}

	public function recaptcha()
	{
		
		$recaptcha = new Zend_Service_ReCaptcha($this->_data['publicKey'], $this->_data['privateKey']);
		$recaptcha->setOptions(array('theme' => 'white'));
		$e = new Zend_Form_Element_Captcha('captcha',
										array	(	'captcha' => 'ReCaptcha',
													'captchaOptions' => array('captcha' => 'ReCaptcha', 'service' => $recaptcha
												)));
		return $e;
	}

	public function _isError($remoteAddr, $challenge, $response)
	{
		$resp = recaptcha_check_answer ($this->_data['privateKey'], $remoteAddr, $challenge, $response);
		if ($resp->is_valid)
		{
			// What happens when the CAPTCHA was entered incorrectly
			return 'VALID';
		} 
		else
		{
			return 'INVALID';
		}
	}
	/*
	public function _isError($data)
	{
		$resp = recaptcha_check_answer ($this->_data['privateKey'], $data->_remoteAddress, $data->_challenge, $data->_response);
		if (!$resp->is_valid)
		{
			// What happens when the CAPTCHA was entered incorrectly
			return true;
		} 
		else
		{
			return false;
		}
	}
	*/
	
	public function getReCaptcha()
	{
		return recaptcha_get_html($this->_data['publicKey']);
	}

}
?>
