<?php
class ContactController extends Zend_Controller_Action
{

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
    }

    public function indexAction()
    {
		//INSTANTIATE
		$recaptcha = new Model_Recaptcha();
		$formData =  array(
							'id' => 'contact',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/contact/val/general',
							'recaptcha' => true, 
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'email',
											'dijitType' => 'validation',
											'label' => 'email',
										),
							'field' => array(
											'required' => 'required',
											'validator' => 'email',
										)
							),
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
											'id' => 'subject',
											'dijitType' => 'validation',
											'label' => 'subject',
										),
							'field' => array(
											'required' => 'required',
											//'maxlength' => "78",

										)
							),
						array(
							'general' => array(
											'id' => 'message',
											'dijitType' => 'editor',
											'label' => 'message',
										),
							'field' => array(
											'required' => 'required',
											'value' => NULL,
										)
							),
						);
		if($this->v['ident'] != NULL){
			$formItems[0]['field']['readonly'] = true;
			$formItems[0]['field']['value'] = $this->v['ident']->email;
			$formItems[1]['field']['readonly'] = true;
			$formItems[1]['field']['value'] = $this->v['ident']->name;
		}
		$layout = $this->_helper->layout();
		$layout->showrecaptcha = true;
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

}

