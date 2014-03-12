<?php

class Admin_PagesController extends Zend_Controller_Action
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
		$mdlPages = new Model_Page();
		$payload = array();
		$payload['pages'] = $mdlPages->getAll();
		$payload['page_count'] = count($payload['pages']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function createAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'login',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/pages/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/pages/val/create',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'module',
											'dijitType' => 'validation',
											'label' => 'module',
										),
							'field' => array(
											'required' => 'required',
										)
							),
						array(
							'general' => array(
											'id' => 'controller',
											'dijitType' => 'validation',
											'label' => 'controller',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'action',
											'dijitType' => 'validation',
											'label' => 'action',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'page-content',
											'dijitType' => 'validation',
											'label' => 'pagecontent',
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

    public function editAction()
    {
		//INSTANTIATE
		$payload = array();
		if( $this->v['params']['val'] != NULL && is_numeric($this->v['params']['val']) && $this->v['params']['val'] > 0){
			$search = array('id' => $this->v['params']['val']);
			$objUser = new Object_DbObj('page');
			$payload['page'] = $objUser->_setPayload($search);
		}
		else{
			$this->_redirect('/admin/pages/index');
		}
		$formData =  array(
							'id' => 'login',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/admin/pages/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/admin/ajax/pages/val/edit',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'module',
											'dijitType' => 'text',
											'label' => 'module',
										),
							'field' => array(
											'required' => 'required',
										)
							),
						array(
							'general' => array(
											'id' => 'controller',
											'dijitType' => 'text',
											'label' => 'controller',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'action',
											'dijitType' => 'text',
											'label' => 'action',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						array(
							'general' => array(
											'id' => 'page-content',
											'dijitType' => 'text',
											'label' => 'pagecontent',
										),
							'field' => array(
											'required' => "required", 
										)
							),
						);
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		

    }


}



