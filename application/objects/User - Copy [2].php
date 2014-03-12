<?php
class Object_User extends Object_Abstract
{
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