<?php

class Admin_ObjectsController extends Zend_Controller_Action
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
		$payload = array();
		$mdlUser = new Model_User();
		$payload['users'] = $mdlUser->getAll();
		$payload['user_count'] = count($payload['users']);
		$mdlTheories = new Model_Sheldontheory();
		$payload['theories'] = $mdlTheories->getAll();
		$payload['theory_count'] = count($payload['theories']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }
	
	
	/*
	 * DEPRECATED ACTIONS
	 *
    public function sheldontheoriesAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'factoids',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/pages/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/objects/val/sheldontheories',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'season',
											'dijitType' => 'number',
											'label' => 'season',
										),
							'field' => array(
											'required' => 'required',
										)
							),
						array(
							'general' => array(
											'id' => 'episode',
											'dijitType' => 'number',
											'label' => 'episode',
										),
							'field' => array(
											'required' => "required",
										)
							),
						array(
							'general' => array(
											'id' => 'youtube',
											'dijitType' => 'validation',
											'label' => 'youtube',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'claim',
											'dijitType' => 'validation',
											'label' => 'claim',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'content',
											'dijitType' => 'validation',
											'label' => 'content',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		

    }

    public function sheldontheorytemplateAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'factoids',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/objects/sheldontheories',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/objects/val/sheldontheorytemplate',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'content-template',
											'dijitType' => 'text',
											'label' => 'contenttemplate',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						);
		$payload = array();
		$search = array(
						'table_name' => 'sheldontheory',
						'category' => 'setup',
						'description' => 'template'
						);
		$objTemplate = new Object_DbObj('tableextras');
		$objTemplate->_setPayload($search);
		$payload['template'] = $objTemplate->_getGeneral();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		

    }

    public function sheldontheoryoverviewAction()
    {
		$payload = array();
		$mdlSheldonTheory = new Model_Sheldontheory();
		$mdlSheldonTheory->_setOrder('chr-asc');
		$payload['theories'] = $mdlSheldonTheory->getAll();
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function sheldontheoryeditAction()
    {
		//INSTANTIATE
		$payload = array();
		if( $this->v['params']['val'] != NULL && is_numeric($this->v['params']['val']) && $this->v['params']['val'] > 0){
			$search = array('id' => $this->v['params']['val']);
			$objUser = new Object_DbObj('sheldontheory');
			$payload['theory'] = $objUser->_setPayload($search);
		}
		else{
			$this->_redirect('/admin/objects/sheldontheoryoverview');
		}
		$formData =  array(
							'id' => 'factoids',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/objects/sheldontheoryoverview',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/objects/val/sheldontheoryedit',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'season',
											'dijitType' => 'number',
											'label' => 'season',
										),
							'field' => array(
											'required' => 'required',
										)
							),
						array(
							'general' => array(
											'id' => 'episode',
											'dijitType' => 'number',
											'label' => 'episode',
										),
							'field' => array(
											'required' => "required",
										)
							),
						array(
							'general' => array(
											'id' => 'youtube',
											'dijitType' => 'validation',
											'label' => 'youtube',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'claim',
											'dijitType' => 'validation',
											'label' => 'claim',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'content',
											'dijitType' => 'validation',
											'label' => 'content',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'id',
											'dijitType' => 'number',
											'label' => 'id',
										),
							'field' => array(
											'required' => 'required',
											'readonly' => true,
										)
							),
						);
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		

    }
	*/

}









