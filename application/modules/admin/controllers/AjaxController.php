<?php

class Admin_AjaxController extends Zend_Controller_Action
{

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
	    //$ajaxContext->addActionContext('index', 'html');
		$ajaxContext->initContext();
    }

    public function indexAction()
    {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		switch($this->v['params']['val'])
		{
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'login':
				$errors = array();
				$errorFlag = false;
				
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('name'))));
				if (!$validatorChain->isValid($_POST['name']))
				{
					$errorFlag = true;
					$errors[] = array('label' => 'name', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if (!$validatorChain->isValid($_POST['password']))
				{
					$errorFlag = true;
					$errors[] = array('label' => 'password', 'errors' => 'regex');
				}
				$login = new stdClass;
				$login->identity = $_POST['name'];
				$login->password = $_POST['password'];
				$this->v['auth']->_setAuthAdapter('admins');
				$result = $this->v['auth']->_authenticate($login);
				//PROCESS
				if($result == false)
				{
					$errorFlag = true;
					$errors[] = array('label' => 'authentication', 'errors' => 'authentication1');
				}		
				if($errorFlag == false)
				{
					$this->getResponse()
						->setHeader('result', 'PASS');
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Login Successfull...');
				}
				else
				{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
		}
    }

    public function pagesAction()
    {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		switch($this->v['params']['val'])
		{
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'create':
				$errors = array();
				$errorFlag = false;

				$data = array();
				$data['module'] = $_POST['module'];
				$data['controller'] = $_POST['controller'];
				$data['action'] = $_POST['action'];
				$data['content'] = $_POST['page-content'];

				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				foreach($data as $key => $val){
					if (!$validatorChain->isValid($val)){
						$errorFlag = true;
						$errors[] = array('label' => $key, 'errors' => 'notempty');
					}
				}
				if($errorFlag == false)
				{
					$this->getResponse()
						->setHeader('result', 'PASS');
					$objContact = new Object_DbObj('page');
					$objContact->_new($data);
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('A new page has been created');
				}
				else
				{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'edit':
				$errors = array();
				$errorFlag = false;

				$data = array();
				$data['module'] = $_POST['module'];
				$data['controller'] = $_POST['controller'];
				$data['action'] = $_POST['action'];
				$data['content'] = $_POST['page-content'];

				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				foreach($data as $key => $val){
					if (!$validatorChain->isValid($val)){
						$errorFlag = true;
						$errors[] = array('label' => $key, 'errors' => 'notempty');
					}
				}
				if($errorFlag == false)
				{
					$this->getResponse()
						->setHeader('result', 'PASS');
					$search = array('id' => $this->v['params']['id']);
					$objPage = new Object_DbObj('page');
					$objPage->_setPayload($search);
					$objPage->_editGeneral(array(
													'module' => $_POST['module'],
													'controller' => $_POST['controller'],
													'action' => $_POST['action'],
													'content' => $_POST['page-content']
													));
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Page has been edited');
				}
				else
				{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			default:
				break;
		}
        // action body
    }

    public function sheldonsaysAction()
    {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		switch($this->v['params']['val'])
		{
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'create':
				$errors = array();
				$errorFlag = false;

				$data = array();
				$data['season'] = $_POST['season'];
				$data['episode'] = $_POST['episode'];
				$data['youtube'] = $_POST['youtube'];
				$data['claim'] = $_POST['claim'];
				$data['content'] = $_POST['content'];

				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				foreach($data as $key => $val){
					if (!$validatorChain->isValid($val)){
						$errorFlag = true;
						$errors[] = array('label' => $key, 'errors' => 'notempty');
					}
				}
				if($errorFlag == false)
				{
					$this->getResponse()
						->setHeader('result', 'PASS');
					$objContact = new Object_DbObj('sheldontheory');
					$objContact->_new($data);
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('A new Sheldon Theory has been created.');
				}
				else
				{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'edit':
				$errors = array();
				$errorFlag = false;

				$data = array();
				$data['season'] = $_POST['season'];
				$data['episode'] = $_POST['episode'];
				$data['youtube'] = $_POST['youtube'];
				$data['claim'] = $_POST['claim'];
				$data['content'] = $_POST['content'];

				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				foreach($data as $key => $val){
					if (!$validatorChain->isValid($val)){
						$errorFlag = true;
						$errors[] = array('label' => $key, 'errors' => 'notempty');
					}
				}
				if($errorFlag == false)
				{
					$this->getResponse()
						->setHeader('result', 'PASS');
					$search = array(
									'id' => $_POST['id'],
									);
					$objTheory = new Object_DbObj('sheldontheory');
					$objTheory->_setPayload($search);
					$objTheory->_editGeneral($data);
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Sheldon Theory has been edited');
				}
				else
				{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'sheldontheorytemplate':
				$this->getResponse()
					->setHeader('result', 'PASS');
				$search = array(
								'table_name' => 'sheldontheory',
								'category' => 'setup',
								'description' => 'template',
								);
				$objTableXtras = new Object_DbObj('tableextras');
				$objTableXtras->_setPayload($search);
				$objContact = new Object_DbObj('tableextras');
				if($objTableXtras->_getGeneral() == NULL){
					$data = array();
					$data['table_name'] = 'sheldontheory';
					$data['category'] = 'setup';
					$data['description'] = 'template';
					$data['value'] = $_POST['content-template'];
					$objContact->_new($data);
				}
				else{
					$objTableXtras->_editGeneral(array('value' => $_POST['content-template']));
				}
				$this->_helper->FlashMessenger
						->setNamespace('success')
						->addMessage('A new Sheldon Factoid has been created');
				break;
			default:
				break;
		}
        // action body

    }

    public function objectsAction()
    {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		switch($this->v['params']['val'])
		{
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'sheldontheories':
				$this->getResponse()
					->setHeader('result', 'PASS');
				$data = array();
				$data['season'] = $_POST['season'];
				$data['episode'] = $_POST['episode'];
				$data['youtube'] = $_POST['youtube'];
				$data['claim'] = $_POST['claim'];
				$data['content'] = $_POST['content'];
				$objContact = new Object_DbObj('sheldontheory');
				$objContact->_new($data);
				$this->_helper->FlashMessenger
						->setNamespace('success')
						->addMessage('A new Sheldon Factoid has been created');
				break;
			case 'sheldontheorytemplate':
				$this->getResponse()
					->setHeader('result', 'PASS');
				$search = array(
								'table_name' => 'sheldontheory',
								'category' => 'setup',
								'description' => 'template',
								);
				$objTableXtras = new Object_DbObj('tableextras');
				$objTableXtras->_setPayload($search);
				$objContact = new Object_DbObj('tableextras');
				if($objTableXtras->_getGeneral() == NULL){
					$data = array();
					$data['table_name'] = 'sheldontheory';
					$data['category'] = 'setup';
					$data['description'] = 'template';
					$data['value'] = $_POST['content-template'];
					$objContact->_new($data);
				}
				else{
					$objTableXtras->_editGeneral(array('value' => $_POST['content-template']));
				}
				$this->_helper->FlashMessenger
						->setNamespace('success')
						->addMessage('A new Sheldon Factoid has been created');
				break;
			case 'sheldontheoryedit':
				$this->getResponse()
					->setHeader('result', 'PASS');
				$data = array();
				$data['season'] = $_POST['season'];
				$data['episode'] = $_POST['episode'];
				$data['youtube'] = $_POST['youtube'];
				$data['claim'] = $_POST['claim'];
				$data['content'] = $_POST['content'];
				$search = array(
								'id' => $_POST['id'],
								);
				$objTheory = new Object_DbObj('sheldontheory');
				$objTheory->_setPayload($search);
				$objTheory->_editGeneral($data);
				$this->_helper->FlashMessenger
						->setNamespace('success')
						->addMessage('A new Sheldon Factoid has been created');
				break;
			default:
				break;
		}
        // action body

    }

}











