<?php
class Object_User extends Object_Abstract
{
	private $_data = array(
		/*CATEGORIES*/	'personal' => array('name', 'username', 'password', 'birthday' ),
						'facebook' => array('oauth_token', 'fb_id'),
						'twitter' => array('access_token', 'token_secret'),
						'token' => array('reason', 'token'),
						);

	protected $_obj = NULL;

	function __construct($search = NULL){
		$this->_setObject('users');
		if($search != NULL){
			$this->_object = $this->_populate($search);
		}
	}
	
	public function _sanitize(){
	}
}

?>