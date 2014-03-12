<?php

class SheldonsaysController extends Zend_Controller_Action
{

    public function init()
    {
		$this->_reflectionClass = new Zend_Reflection_Class($this);
		$this->_errorHandler = new Class_Errorhandler();
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
    }

    public function indexAction()
    {
		$payload = array();
		$search = array('module' => 'default', 'controller' => 'sheldonsays', 'action' => 'index');
		$objUser = new Object_DbObj('page');
		$objResult = $objUser->_setPayload($search);
		$payload['gen'] = $objUser->_getGeneral();
		//$payload['gen']['message'] = html_entity_decode($payload['gen']['message']);
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function theoriesAction()
    {
		$payload = array();
		$value = $this->v['params']['val'];
		if($value == NULL || !is_numeric($value) || $value <= 0 ){
			$sort = trim($this->v['params']['sort']);
			$mdlSheldonFactoid = new Model_Sheldontheory();
			$mdlSheldonFactoid->_setOrder($sort);
			$payload['factoids'] = $mdlSheldonFactoid->getAll($sort);
		}
		else{
			$search = array('id' => $value);
			$obj = new Object_DbObj('sheldontheory');
			$obj->_setPayload($search);
			$objGeneral = $obj->_getGeneral();
			if($objGeneral['youtube'] <= 0 || $objGeneral['youtube'] == NULL){
				//INSTANTIATE
				$formData =  array(
									'id' => 'youtube',
									'encType' => 'multipart/form-data',
									'action' => '',
									'method' => 'post',
									'uri' => '/sheldonsays/theories',
									'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
									'validate' => '/ajax/sheldontheory/val/youtube/id/' . $this->v['params']['val'],
									'recaptcha' => true, 
									);
				$formItems = array(
							array(
								'general' => array(
												'id' => 'youtube',
												'dijitType' => 'validation',
												'label' => 'youtube',
											),
								'field' => array(
												'required' => 'required',
												'regExp' => $this->v['g']->_getRegexJS('alphanumericwithunderscore'),
	
											)
								),
								);
		
				$layout = $this->_helper->layout();
				$layout->showrecaptcha = true;
				$payload['formData'] = $formData;
				$payload['formItems'] = $formItems;
			}
			$obj->_editGeneral(array('views' => $objGeneral['views'] + 1));
			$payload['factoid'] = $obj->_getGeneral();
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		

    }


}



