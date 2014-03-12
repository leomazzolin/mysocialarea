<?php
class Object_Newuser extends Object_Object
{
	private $_data = array(
		/*CATEGORIES*/	'personal' => array('name', 'username', 'password', 'birthday' ),
						'facebook' => array('oauth_token', 'fb_id'),
						'twitter' => array('access_token', 'token_secret'),
						'token' => array('reason', 'token'),
						);


	function __construct($obj = NULL, $search = NULL){
		parent::__construct($obj, $search);
	}
	
	public function _sanitize(){
	}
}

?>