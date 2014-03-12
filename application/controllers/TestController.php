<?php

class TestController extends Zend_Controller_Action
{

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
		//$this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'login',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/',
							'place' => 'l-center-content',
							'validate' => '/ajax/user/val/login',
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
		$this->view->formErrorMsg = NULL;
		$generalErrorMsg = 'An error occured...please start over.';
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		$abstract = new Model_Table('abstract');
		$item = array( 'col' => 'req1', 'val' => 'data1' );
		$category = 'hello';
		$description = 'there'; 
		/*
		$itemdata = array();
		$itemdata[] = array('category' => 'dataCATEGORY1',
							'description' => 'dataDESCRIPTION1',
							'value' => 'dataVALUE1'
							);
		$itemdata[] = array('category' => 'dataCATEGORY2',
							'description' => 'dataDESCRIPTION2',
							'value' => 'dataVALUE2'
							);
		*/
		$payload['abstract'] = $abstract->_read($item);
		echo Zend_Json::encode($payload);

		/*
		$layout = $this->_helper->layout();
		$auth = Zend_Auth::getInstance();
		$date_now =  $this->_u->get_part_of_now('date_now');
		
		//INSTANTIATE
		$pssPictureTable = new Zend_Db_Table('pss_picture');
		$select = $pssPictureTable->select()->from('pss_picture',array('id', 'orientation', 'extension'));
		$rows = $pssPictureTable->fetchAll($select);
		$this->view->pics = Zend_Json::encode($rows->toArray());
		$this->_u->dump($_POST);
		$config = new Zend_Config_Ini('../application/configs/application.ini', APPLICATION_ENV);
		$db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params->toArray());
		*/
		/*
		$this->_helper->getHelper('FlashMessenger')
				->setNamespace('notice')
				->addMessage(	'An email has been sent to the supplied email address to complete the sign up process.
								<br />
								Please check your email inbox.
								');
		*/
    }


}

