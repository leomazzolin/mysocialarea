<?php

class FacebookController extends Zend_Controller_Action
{

    public function init()
    {
		
    }

    public function indexAction()
    {
		//GET FACEBOOK DATA FROM INI FILE
		$fb = new stdClass();
		$bootstrap = $this->getInvokeArg('bootstrap');
		$aConfig = $bootstrap->getOptions();
		$fb->_app_id = $aConfig['my']['facebook']['app_id'];
		$fb->_api_key = $aConfig['my']['facebook']['api_key'];
		$fb->_secret = $aConfig['my']['facebook']['secret'];
		///////////////////////////////////////////////////////////////
				
		function parse_signed_request($signed_request, $secret) {
			list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
			
			// decode the data
			$sig = base64_url_decode($encoded_sig);
			$data = json_decode(base64_url_decode($payload), true);
			
			if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
				error_log('Unknown algorithm. Expected HMAC-SHA256');
				return null;
			}
			
			// check sig
			$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
			if ($sig !== $expected_sig) {
				error_log('Bad Signed JSON signature!');
				return null;
			}
			
			return $data;
		}
		
		function base64_url_decode($input) {
			return base64_decode(strtr($input, '-_', '+/'));
		}
		
		if ($_REQUEST) {
			//INSTANTIATE NEW OBJECTS
			$pssFacebook = new Zend_Db_Table('facebook');
			$pssUser = new Zend_Db_Table('users');
			$flag = NULL;
			//MAKE RESPONSE OBJECT
			$response = parse_signed_request($_REQUEST['signed_request'], $fb->_secret);
			/*
			$select = $pssUser->select()->where('email = ?', $response['registration']['email']);
			$pssUserRow = $pssUser->fetchRow($select);
			if($pssUserRow)
			{
				$flag = 'pre-existing user';
			}
			$select = $pssFacebook->select()->where('email = ?', $response['registration']['email']);
			$pssFBRow = $pssFacebook->fetchRow($select);
			*/
			$auth = Zend_Auth::getInstance();
			if($auth->hasIdentity())
			{
				$identity = $auth->getIdentity();
				$data = array();
				$data['user_id'] = $identity->id;
				$data['oauth_token'] = $response['oauth_token']; $data['fb_id'] = $response['user_id'];
				$data['name'] = $response['registration']['name']; $data['email'] = $response['registration']['email']; $data['password'] = md5($response['registration']['password']);
				$data['last_updated'] = date("Y-m-d H:i:s", time());
				$pssFacebook->insert($data);
			}
			else
			{
				$select = $pssUser->select()->where('email = ?', $response['registration']['email']);
				$pssUserRow = $pssUser->fetchRow($select);
				if($pssUserRow)
				{
					$flag = 'pre-existing user';
				}
				else
				{
					$select = $pssFacebook->select()->where('email = ?', $response['registration']['email']);
					$pssFBRow = $pssFacebook->fetchRow($select);
					if($pssFBRow)
					{
					}
					else
					{
						$array = explode('/', $response['registration']['birthday']);
						$birthday = $array[2] . '-' . $array[0] . '-' . $array[1];
						$data = array();
						$data['email'] = $response['registration']['email']; $data['name'] = $response['registration']['name'];
						$data['birthday'] = $birthday;
						$data['password'] = md5($response['registration']['password']);
						$data['last_updated'] = date("Y-m-d H:i:s", time());
						$pssUser->insert($data);
						$select = $pssUser->select()->where('email = ?', $response['registration']['email']);
						$pssUserRow = $pssUser->fetchRow($select);
						$data = array();
						$data['oauth_token'] = $response['oauth_token']; $data['user_id'] = $pssUserRow->id; $data['fb_id'] = $response['user_id'];
						$data['name'] = $response['registration']['name']; $data['email'] = $response['registration']['email']; $data['password'] = md5($response['registration']['password']);
						$data['last_updated'] = date("Y-m-d H:i:s", time());
						$pssFacebook->insert($data);
					}
				}
			}
			$this->_redirect('/default/index/index');
		  /*
		  echo '<pre>';
		  print_r($response);
		  echo '</pre>';
		  */
		  
		} else {
		  echo '$_REQUEST is empty';
		}
    }

    public function deauthAction()
    {
		$this->_helper->layout->disableLayout();
		$fb = new stdClass();
		$bootstrap = $this->getInvokeArg('bootstrap');
		$aConfig = $bootstrap->getOptions();
		$fb->_app_id = $aConfig['my']['facebook']['app_id'];
		$fb->_api_key = $aConfig['my']['facebook']['api_key'];
		$fb->_secret = $aConfig['my']['facebook']['secret'];
				
		function parse_signed_request($signed_request, $secret) {
			list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
			
			// decode the data
			$sig = base64_url_decode($encoded_sig);
			$data = json_decode(base64_url_decode($payload), true);
			
			if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
				error_log('Unknown algorithm. Expected HMAC-SHA256');
				return null;
			}
			
			// check sig
			$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
			if ($sig !== $expected_sig) {
				error_log('Bad Signed JSON signature!');
				return null;
			}
			
			return $data;
		}
		
		function base64_url_decode($input) {
			return base64_decode(strtr($input, '-_', '+/'));
		}
		
		if ($_REQUEST) {
			//INSTANTIATE NEW OBJECTS
			$pssFacebook = new Zend_Db_Table('facebook');
			$pssUser = new Zend_Db_Table('users');
			//MAKE RESPONSE OBJECT
			$response = parse_signed_request($_REQUEST['signed_request'], $fb->_secret);
			$where = $pssFacebook->getAdapter()->quoteInto('fb_id = ?', $response['user_id']);
			$pssFacebook->delete($where);
		} else {
		  echo '$_REQUEST is empty';
		}
    }

    public function xdreceiverAction()
    {
		$this->_helper->layout->disableLayout();
    }


}





