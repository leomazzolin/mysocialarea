<?php

class Model_Auth
{
	protected $_adapter = array(
								'users' => array(
													'table' => 'user',
													'identity' => 'email',
													'credentials' => 'pwd'
													),
								'admins' => array(
													'table' => 'admins',
													'identity' => 'name',
													'credentials' => 'password'
													),
								);
	protected $_authAdapter;
	protected $_userType;
								

	function __construct($adapter = NULL)
	{
		if($adapter != NULL){
			$this->setAuthAdapter($adapter);
		}

	}
	
	public function _setAuthAdapter($adapter){
		$this->_userType = $adapter;
		$db = Zend_Db_Table::getDefaultAdapter();
		//create the auth adapter
		$this->_authAdapter = new Zend_Auth_Adapter_DbTable(	
														$db,
														$this->_adapter[$adapter]['table'],
														$this->_adapter[$adapter]['identity'],
														$this->_adapter[$adapter]['credentials']
													);
		return $this->_authAdapter;

	}

	public function _authenticate($data)
	{
		if($data->identity == NULL){
			$data->identity = 'not_given';
		}
		$this->_authAdapter->setIdentity($data->identity);
		$this->_authAdapter->setCredential(md5($data->password));
		//authenticate
		$result = $this->_authAdapter->authenticate();
		if ($result->isValid()) {
			// store the username, first and last names of the user
			$auth = Zend_Auth::getInstance();
			$storage = $auth->getStorage();
			$storageItems = new stdClass();
			switch($this->_userType){
				case 'users':
					$storageItems = $this->_authAdapter->getResultRowObject(array('id', 'email'));
					$search = array('id' => $storageItems->id);
					$objUser = new Object_DbObj('user');
					$objResult = $objUser->_setPayload($search);
					$storageItems->userType = $this->_userType;
					$storageItems->name = $objUser->_getDataItem('personal', 'name');
					$storageItems->username = $objUser->_getDataItem('personal', 'username');
					break;
				case 'admins':
					$storageItems = $this->_authAdapter->getResultRowObject(array('id', 'name'));
					$storageItems->userType = $this->_userType;
					break;
				default:
					break;
			}
			$storage->write($storageItems);
			return true;
		}
		else{
			return false;
		}
	}

}

