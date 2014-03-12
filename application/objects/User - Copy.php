<?php
class Object_User extends Object_Abstract
{
	protected $_user = NULL;

	function __construct($search = NULL){
		$this->_setObject('users');
		if($search != NULL){
			$this->_user = $this->_populate($search);
		}else{
			return NULL;
		}
	}
	
	public function _get($category = NULL, $description = NULL){
		return $this->_user;
	}
	
	public function _fetchPersonalData($id){
		$payload = array();
		$search = array(
			'ref_id' => $id,
			'category' => 'personal',
		);
		$result = $this->_readData($search);
		foreach($result as $r){
			$payload[$r['description']] = trim($r['value']);
		}
		return $payload;
	}
}

?>