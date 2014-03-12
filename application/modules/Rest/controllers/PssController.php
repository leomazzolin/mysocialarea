<?php

class Rest_PssController extends Zend_Controller_Action
{

    public function init()
    {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_todo = array (
			"1" => "Buy milk",
			"2" => "Pour glass of milk",
			"3" => "Eat cookies"
		);
		$this->_fields = array(
			array(	
					'general' => array(	
										'id' => 'email', 'dijitType' => 'vtb'
										),
					'field' => array(	'required' => 'required',
										'validator' => ' dojox.validate.isEmailAddress',
										'invalidMessage' => 'Invalid Email format'
										),
					'label' => array(	
										'innerHTML' => 'Email', 'class' => 'required'
										)
				),
			array(	
					'general' => array(
										'id' => 'cemail', 'dijitType' => 'vtb'
										),
					'field' => array(	
										'required' => 'required',
										'validator' => ' dojox.validate.isEmailAddress',
										'invalidMessage' => 'Invalid Email format',
										'data-mysa-conf' => 'email'
									),
					'label' => array(	
										'innerHTML' => 'Confirm Email', 'class' => 'required'
									)
				),
			array(	
					'general' => array(
										'id' => 'password', 'dijitType' => 'vtb'
									),
					'field' => array(	
										'required' => 'required',
										'regExp' => '[a-zA-Z0-9\-\_]\{6,20}',
										'invalidMessage' => 'Invalid password format<br />A-Z, a-z, 0-9, dash (-), underscore (_)  only<br />6-20 characters',
										'type' => 'password',
										'maxlength' => '20'
									),
					'label' => array(	
										'innerHTML' => 'Password',
										'class' => 'required'
									)
				)
		);

    }

    public function indexAction()
    {
        echo Zend_Json::encode($this->_fields);
    }

    public function getAction()
    {
		$id = $this->_getParam('id');
		 echo Zend_Json::encode($this->_todo[$id]);

    }

    public function postAction()
    {
		$item = $this->_request->getPost('item');
		
		  $this->_todo[count($this->_todo) + 1] = $item;
		
		  echo Zend_Json::encode($this->_todo);
    }

    public function putAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }


}









