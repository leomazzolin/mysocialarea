<?php
/*
require_once 'twitter-async/EpiCurl.php';
require_once 'twitter-async/EpiOAuth.php';
require_once 'twitter-async/EpiTwitter.php';
require_once 'twitter-async/EpiSequence.php';
*/

class Model_Twitter
{
	protected $_data = array();
	protected $_twitterObjUnAuth;
	
	public function __construct()
	{
   		$config = Zend_Registry::get("appOptions");
		$this->_data['c_k'] = $config['my']['twitter']['key'];
		$this->_data['c_s'] =  $config['my']['twitter']['secret'];
		$this->_twitterObjUnAuth = new Twitter_Twitter($this->_data['c_k'], $this->_data['c_s']);
	}
	
	public function get_data()
	{
		return $this->_data;
	}

	public function get_friends()
	{
		return $this->_twitterObj->get('/statuses/friends.json');
	}

	public function getForcedLoginUrl()
	{
		try
		{
			return $this->_twitterObjUnAuth->getAuthenticateUrl(null, array("force_login" => true));
		}
		catch (EpiOAuthException $e)
		{
			echo 'Error in Model_Twitteradmin->getForcedLogin() -- EpiOAuthException raised';
		}
		catch (EpiTwitterException $e)
		{
			echo 'Error in Model_Twitteradmin->getForcedLogin() -- EpiTwitterException raised';
		}
	}

	public function getUnForcedLoginUrl()
	{
		try
		{
			return $this->_twitterObjUnAuth->getAuthenticateUrl();
		}
		catch (EpiOAuthException $e)
		{
			echo 'Error in Model_Twitteradmin->getUnForcedLogin() -- EpiOAuthException raised';
		}
		catch (EpiTwitterException $e)
		{
			echo 'Error in Model_Twitteradmin->getUnForcedLogin() -- EpiTwitterException raised';
		}
	}

	public function getAuthorizeUrl()
	{
		try
		{
			return $this->_twitterObjUnAuth->getAuthorizeUrl();
		}
		catch (EpiOAuthException $e)
		{
			echo 'Error in Model_Twitteradmin->getAuthorizeUrl() -- EpiOAuthException raised';
		}
		catch (EpiTwitterException $e)
		{
			echo 'Error in Model_Twitteradmin->getAuthorizeUrl() -- EpiTwitterException raised';
		}
	}
	
	public function verify($twitter)
	{
		if(is_object($twitter))
		{
			$response = $twitter->get_Account_Verify_credentials();
			return $this->check($response);
		}
		else
		{
			return false;
		}
	}
	
	public function check($payload)
	{
		return ($payload->code == 200) ? $payload : false;
	}
		
}

?>