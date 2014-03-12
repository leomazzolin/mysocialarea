<?php

class HelpController extends Zend_Controller_Action
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
		$payload = array();
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);
    }

    public function privacyAction()
    {
		$payload = array();
		$search = array('module' => 'default', 'controller' => 'help', 'action' => 'privacy');
		$objUser = new Object_DbObj('page');
		$objResult = $objUser->_setPayload($search);
		$payload['gen'] = $objUser->_getGeneral();
		//$payload['gen']['message'] = html_entity_decode($payload['gen']['message']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function touAction()
    {
		$payload = array();
		$search = array('module' => 'default', 'controller' => 'help', 'action' => 'tou');
		$objUser = new Object_DbObj('page');
		$objResult = $objUser->_setPayload($search);
		$payload['gen'] = $objUser->_getGeneral();
		//$payload['gen']['message'] = html_entity_decode($payload['gen']['message']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }


}





