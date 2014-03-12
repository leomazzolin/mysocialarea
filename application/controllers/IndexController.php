<?php

class IndexController extends Zend_Controller_Action
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
	
	
	/*
    public function indexAction()
    {
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		try{
			$payload = array();
			$search = array('id' => 1);
			$objUser = new Object_DbObj('user');
			$objResult = $objUser->_setPayload($search);
			//$objUser->_new(array('email' => 'email', 'pwd' => 'password'));
			//$payload['delete'] = $objUser->_delete();
			//if($objResult != NULL){
				//$objUser->_editGeneral(array('email' => 'leomazzolin@rogers.com'));
			//}
			//$objUser->_popGeneral('pwd');
			$payload['id'] = $objUser->_getId();
			$payload['gen'] = $objUser->_getGeneral();
			//$payload['data'] = $objUser->_getData();
			//$payload['data'] = $objUser->_getDataItem('personal', 'name');
			//$payload['data'] = $objUser->_getDataCategory('personal');
			//$payload['new_id'] = $objUser->_new(array('email' => 'leomazzolin', 'pwd' => '123456'));
			//$id = $objUser->_getData('personal', 'name', 'id');
			//$objUser->_editGeneral(array('email' => 'leomazzolin@rogers.com'));
			//$objUser->_updateData(array(
			//						array('category' => 'test', 'description' => 'gatsu1', 'value' => 'Leo the Stud'),
			//						array('category' => 'test', 'description' => 'gatsu2', 'value' => 'Leo the Stud'),
			//						array('category' => 'test', 'description' => 'gatsu3', 'value' => 'Leo the Stud'),
			//						array('category' => 'test', 'description' => 'gatsu4', 'value' => 'Leo the Stud'),
			//					));
			$payload['data'] = $objUser->_getData();
			//$payload['delete_count1'] = $objUser->_deleteDataItem(array(
			//														array('category' => 'test', 'description' => 'gatsu1'),
			//													));
			//$payload['delete_count2'] = $objUser->_deleteDataItemById(array($objUser->_getDataItem('test', 'gatsu2', 'id')));
			//$payload['delete_count3'] = $objUser->_deleteDataCategory(array('test'));
			//$objUser->_updateDataById(array(
			//						array('id' =>  $objUser->_getDataItem('test', 'gatsu3', 'id'), 'value' => 'Leo the Stud'),
			//						array('id' => $objUser->_getDataItem('test', 'gatsu4', 'id'), 'value' => 'Leo the Stud'),
			//					));
			//$payload['new_gen'] = $objUser->_getGeneral();
			//$payload['new_personal'] = $objUser->_getCategory('personal');
			//$payload['new_id'] = $objUser->_getId();
			//$payload['new_gen'] = $objUser->_getGeneral();
			//$payload['new_data'] = $objUser->_getData('personal');
			Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
		} catch (Exception $e) {
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
    }
	*/
	
	public function indexAction(){
		$payload = array();
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
	}
	
    public function factiodsAction()
    {
			$payload = array();
    }


}



