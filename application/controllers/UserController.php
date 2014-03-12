<?php

class UserController extends Zend_Controller_Action
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
		if($this->v['ident'] == NULL){
			$this->_redirect('/user/login');
		}
		else{
			//INSTANTIATE OBJECTS	
			$objUser = new Object_DbObj('user');
			$objUser->_setPayload(array('id' => $this->v['ident']->id));
			$payload['id'] = $objUser->_getId();
			$payload['general'] = $objUser->_getGeneral();
			unset($payload['general']['pwd']);
			$payload['personal'] = $objUser->_getDataCategory('personal');
			$users = array();
			$users[] = array( 'Email', 'Created', 'Modified');
			$buffer =  $objUser->_getGeneral();
			$data = array($buffer['email'], $buffer['created'], $buffer['modified']);
			$users[] = $data;
			$objUser = new Object_DbObj('user');
			$objUser->_setPayload(array('email' => 'leo@mysocialarea.com'));
			$buffer =  $objUser->_getGeneral();
			$data = array($buffer['email'], $buffer['created'], $buffer['modified']);
			$users[] = $data;
			$payload['users'] = $users;
			$payload['md5'] = md5(1);
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);
    }


    public function activateAction()
    {
		$formData =  array(
							'id' => 'activate',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/activate',
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
						array(
							'general' => array(
											'id' => 'token',
											'dijitType' => 'validation',
											'label' => 'token',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('token'),
											'maxlength' => "6",
										)
							),
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function loginAction()
    {
		//INSTANTIATE
		$formData =  array(
							'id' => 'login',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
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
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function logoutAction()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			$auth->clearIdentity();
		}
		//$layout = $this->_helper->layout();
		$this->_redirect('/');
    }

    public function profileAction()
    {
		$mdl_U = new Model_Users();
		$u = new Model_My_Utility();

		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
			$info = $mdl_U->get_all_info($identity->id);
			$this->view->info = $info;
		}
		else
		{
		$this->_redirect('/user/login');
		}
		
    }

    public function emailAction()
    {
		if($this->v['ident'] == NULL){
			$this->_redirect('/user/login');
		}
		//INSTANTIATE
		$formData =  array(
							'id' => 'change-email',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/user/confirmemail',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/email',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'nemail',
											'dijitType' => 'validation',
											'label' => 'nemail',
										),
							'field' => array(
											'required' => 'required',
											'validator' => 'email',
										)
							),
						array(
							'general' => array(
											'id' => 'cemail',
											'dijitType' => 'validation',
											'label' => 'cemail',
										),
							'field' => array(
											'required' => 'required',
											'validator' => 'email',
										)
							),
						array(
							'general' => array(
											'id' => 'oemail',
											'dijitType' => 'validation',
											'label' => 'oemail',
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
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function confirmemailAction()
    {
		$this->v['ident'] = NULL;
		$formData =  array(
							'id' => 'confirm-email',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/confirmemail',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'email',
											'dijitType' => 'validation',
											'label' => 'nemail',
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
						array(
							'general' => array(
											'id' => 'token',
											'dijitType' => 'validation',
											'label' => 'token',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('token'),
											'maxlength' => "6",
										)
							),
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function personalAction()
    {
		if($this->v['ident'] == NULL)
		{
			$this->_redirect('/user/login');
		}
		else{
			$objUser = new Object_DbObj('user');
			$objUser->_setPayload(array('id' => $this->v['ident']->id));
			$username = $objUser->_getDataItem('personal', 'username');
			$name = $objUser->_getDataItem('personal', 'name');
			$birthday = $objUser->_getDataItem('personal', 'birthday');
		}
		//INSTANTIATE
		$formData =  array(
							'id' => 'personal',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/user/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/personal',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'username',
											'dijitType' => 'validation',
											'label' => 'username',
										),
							'field' => array(
											'required' => 'required',
											'regExp' => $this->v['g']->_getRegexJS('username'),
											'maxlength' => "10",
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
											'id' => 'birthday',
											'dijitType' => 'date',
											'label' => 'birthday',
										),
							'field' => array(
												'required' => 'required',
										)
							),
						);
		$formItems[0]['field']['value'] = $username;
		$formItems[1]['field']['value'] = $name;
		$formItems[2]['field']['value'] = $birthday;
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function passwordAction()
    {
		if($this->v['ident'] == NULL)
		{
			$this->_redirect('/user/login');
		}
		//INSTANTIATE
		$formData =  array(
							'id' => 'change-email',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/user/index',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/password',
							);
		$formItems = array(
						array(
							'general' => array(
											'id' => 'npassword',
											'dijitType' => 'validation',
											'label' => 'npassword',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						array(
							'general' => array(
											'id' => 'cpassword',
											'dijitType' => 'validation',
											'label' => 'cpassword',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						array(
							'general' => array(
											'id' => 'curpassword',
											'dijitType' => 'validation',
											'label' => 'curpassword',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function forgotpasswordAction()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$auth->clearIdentity();
		}
		$layout = $this->_helper->layout();
		$layout->_jsonIdentity = '"NOT_SIGNED_IN"';
		//INSTANTIATE
		$formData =  array(
							'id' => 'forgotpassword',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/user/resetpassword',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/forgotpassword',
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
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function resetpasswordAction()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$auth->clearIdentity();
		}
		$layout = $this->_helper->layout();
		$layout->_jsonIdentity = '"NOT_SIGNED_IN"';
		$formData =  array(
							'id' => 'resetpassword',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/resetpassword',
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
											'label' => 'npassword',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						array(
							'general' => array(
											'id' => 'cpassword',
											'dijitType' => 'validation',
											'label' => 'cpassword',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						array(
							'general' => array(
											'id' => 'token',
											'dijitType' => 'validation',
											'label' => 'token',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('token'),
											'maxlength' => "6",
										)
							),
						);
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }

    public function registerAction()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$auth->clearIdentity();
		}
		$layout = $this->_helper->layout();
		$layout->_jsonIdentity = '"NOT_SIGNED_IN"';
		//INSTANTIATE
		$formData =  array(
							'id' => 'register',
							'encType' => 'multipart/form-data',
							'action' => '',
							'method' => 'post',
							'uri' => '/user/activate',
							'place' => $this->v['attch_pts']['default']['layout']['content']['center'],
							'validate' => '/ajax/user/val/register',
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
											'id' => 'cemail',
											'dijitType' => 'validation',
											'label' => 'cemail',
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
											'id' => 'username',
											'dijitType' => 'validation',
											'label' => 'username',
										),
							'field' => array(
											'required' => 'required',
											'regExp' => $this->v['g']->_getRegexJS('username'),
											'maxlength' => "10",
										)
							),
						array(
							'general' => array(
											'id' => 'birthday',
											'dijitType' => 'date',
											'label' => 'birthday',
										),
							'field' => array(
												'required' => 'required',
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
						array(
							'general' => array(
											'id' => 'cpassword',
											'dijitType' => 'validation',
											'label' => 'cpassword',
										),
							'field' => array(
											'required' => "required", 
											'regExp' => $this->v['g']->_getRegexJS('password'),
											'type' => "password",
											'maxlength' => "20",
										)
							),
						array(
							'general' => array(
											'id' => 'tou',
											'dijitType' => 'checkbox',
											'label' => 'tou',
										),
							'field' => array(
											'required' => "required",
											'label'=> 'I agree to the Terms of Use...<a href="/help/tou" target="_blank">View</a>', 
										)
							),
						array(
							'general' => array(
											'id' => 'privacy',
											'dijitType' => 'checkbox',
											'label' => 'privacy',
										),
							'field' => array(
											'required' => "required", 
											'label'=> 'I agree to the Privacy Terms...<a href="/help/privacy" target="_blank">View</a>', 
										)
							),
						);
		$this->view->formErrorMsg = NULL;
		$generalErrorMsg = 'An error occured...please start over.';
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$this->_redirect('/');
		}
		$payload = array();
		$payload['formData'] = $formData;
		$payload['formItems'] = $formItems;
		Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);		
    }


}

/*
    public function signupAction()
    {
		$form = new Form_User_Form1();
		
		$form->setup_signup_action();
		
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$auth->clearIdentity();
		}
		
		if ($this->_request->isPost()) {
			if ($form->isValid($_POST)) {
				$mdlUser = new Model_Users();
				$token = rand(100000, 999999);
				$token_reason = 'new_user';
				$data = new stdClass;
				$data->email = $form->getValue('email');
				$data->token = $token;
				$data->token_reason = $token_reason;
				$mdlUser->create($data);
				$mailSet = new Model_MailSetup();
				$mailObj = new Zend_Mail();
				$host = new Zend_Mail_Transport_Smtp( $mailSet->getHost(), $mailSet->getConfigInfo());
            	$html = $this->view->partial('templates/emails/signup.phtml', 'default',  $data);
				$from = $mailSet->getFrom( 'contact' );
				$to = $form->getValue('email');
				$subj = "MySocialArea.com New User Sign Up";
				$mailObj->setBodyHtml($html);
				$mailObj->setFrom($from, 'MySocialArea.com Admin');
				$mailObj->addTo($to);
				$mailObj->setSubject($subj);
				$mailObj->send($host);
				$authAdapter = Zend_Auth::getInstance();
				$authAdapter->clearIdentity();
				$this->_helper->FlashMessenger()
						->setNamespace('notice')
						->addMessage(	'An email has been sent to the supplied email address to complete the sign up process.
										<br />
										Please check your email inbox.
										');
				$this->_redirect('/user/activate');
			}
		}
		
		$this->view->form = $form;
    }
*/