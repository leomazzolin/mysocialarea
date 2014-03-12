<?php

class Admin_SheldonsaysController extends Zend_Controller_Action
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
		$mdlSheldonTheory = new Model_Sheldontheory();
		$mdlSheldonTheory->_setOrder('chr-asc');
		$payload['theories'] = $mdlSheldonTheory->getAll();
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function createAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'factoids',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/sheldonsays/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/sheldonsays/val/create',
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
											/*
											'smallDelta' => '1',
											'min' => 1,
											'max' => 30,
											'places' => 0,
											'value' => 1,
											*/
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
		$search = array(
						'table_name' => 'sheldontheory',
						'category' => 'setup',
						'description' => 'template'
						);
		$objTableXtras = new Object_DbObj('tableextras');
		$payload['template'] = $objTableXtras->_setPayload($search);
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function editAction()
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
							'uri' => '/admin/sheldonsays/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/sheldonsays/val/edit',
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
											/*
											'smallDelta' => '1',
											'min' => 1,
											'max' => 30,
											'places' => 0,
											'value' => 1,
											*/
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

    public function viewAction()
    {
		$payload = array();
		if( $this->v['params']['val'] != NULL && is_numeric($this->v['params']['val']) && $this->v['params']['val'] > 0){
			$search = array('id' => $this->v['params']['val']);
			$obj = new Object_DbObj('sheldontheory');
			$result = $obj->_setPayload($search);
			if($result == NULL){
				$this->_redirect('/admin/sheldonsays/index');
			}
			else{
				$payload['gen'] = $obj->_getGeneral();
				$payload['youtubeIds'] = unserialize($obj->_getDataItem('youtube', 'ids'));				
				Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
			}
		}
		else{
			$this->_redirect('/admin/sheldonsays/index');
		}
    }


}







