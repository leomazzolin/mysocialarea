<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
 		$auth = Zend_Auth::getInstance();
		if($this->v['params']['action'] != 'login'){
			if(!$auth->hasIdentity()) {
				$this->_redirect('/admin/index/login');
			}		
		}
    }

    public function indexAction()
    {
		$payload = array();
		$mdlUser = new Model_User();
		$payload['users'] = $mdlUser->getAll();
		$payload['user_count'] = count($payload['users']);
		$mdlTheories = new Model_Sheldontheory();
		$payload['theories'] = $mdlTheories->getAll();
		$payload['theory_count'] = count($payload['theories']);
		$mdlPages = new Model_Page();
		$payload['pages'] = $mdlPages->getAll();
		$payload['page_count'] = count($payload['pages']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
		
    }

    public function loginAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'login',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/index/index',
							'place' => 'l-center-content',
							'validate' => '/admin/ajax/index/val/login',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'name',
											'dijitType' => 'validation',
											'label' => 'name',
										),
							'field' => array(
											'required' => 'required',
											'regExp' => $this->v['g']->_getRegexJS('name'),
										)
							),
						array(
							'general' => array(
											'id' => 'password',
											'dijitType' => 'validation',
											'label' => 'password',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }


}



