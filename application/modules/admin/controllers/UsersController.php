<?php

class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
 		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity()) {
			$this->_redirect('/admin/index/login');
		}		
    }

    public function indexAction()
    {
		$mdlUsers = new Model_User();
		$payload = array();
		$payload['users'] = $mdlUsers->getAll();
		$payload['user_count'] = count($payload['users']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }


}

