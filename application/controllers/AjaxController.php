<?php

class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
		$this->_helper->layout->disableLayout();
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
	   // $ajaxContext->addActionContext('index', 'html');
		//$ajaxContext->initContext();
    }

    public function contactAction()
    {
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		switch($this->v['params']['val']){
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'general':
				$recaptcha = new Model_Recaptcha();
	
				$errors = array();
				$errorFlag = false;
				
				$recapResult = $recaptcha->_isError($_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
				if ($recapResult == 'INVALID'){
					$errorFlag = true;
					$errors[] = array('label' => 'recaptcha', 'errors' => 'recaptcha');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('name'))));
				if (!$validatorChain->isValid($_POST['name'])){
					$errorFlag = true;
					$errors[] = array('label' => 'name', 'errors' => 'regex');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				if (!$validatorChain->isValid($_POST['subject'])){
					$errorFlag = true;
					$errors[] = array('label' => 'subject', 'errors' => 'notempty');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				if (!$validatorChain->isValid($_POST['message-input'])){
					$errorFlag = true;
					$errors[] = array('label' => 'message', 'errors' => 'notempty');
				}
				if($errorFlag == false){
					$data = new stdClass;
					$data->email = $_POST['email'];
					$data->name = $_POST['name'];
					$data->subject = $_POST['subject'];
					$data->message = $_POST['message-input'];
					$mailSet = new Model_MailSetup();
					$mailObj = new Zend_Mail();
					$host = new Zend_Mail_Transport_Smtp( $mailSet->getHost(), $mailSet->getConfigInfo());
					$html = $this->view->partial('templates/emails/contact1.phtml', 'default',  $data);
					//$from = $mailSet->getFrom('contact');
					$to = 'admin@mysocialarea.com';
					$subj = $_POST['subject'];
					$mailObj->setBodyHtml($html);
					$mailObj->setFrom($_POST['email'], $_POST['email']);
					$mailObj->addTo($to);
					$mailObj->setSubject($subj);
					$mailObj->send($host);
					$this->getResponse()->setHeader('result', 'PASS');
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Your inquiry has been sent.');
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			/*
			case 'general':
				$recaptcha = new Model_Recaptcha();
	
				$errors = array();
				$errorFlag = false;
				
				$recapResult = $recaptcha->_isError($_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
				if ($recapResult == 'INVALID'){
					$errorFlag = true;
					$errors[] = array('label' => 'recaptcha', 'errors' => 'recaptcha');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('name'))));
				if (!$validatorChain->isValid($_POST['name'])){
					$errorFlag = true;
					$errors[] = array('label' => 'name', 'errors' => 'regex');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				if (!$validatorChain->isValid($_POST['subject'])){
					$errorFlag = true;
					$errors[] = array('label' => 'subject', 'errors' => 'notempty');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				if (!$validatorChain->isValid($_POST['message-input'])){
					$errorFlag = true;
					$errors[] = array('label' => 'message', 'errors' => 'notempty');
				}
				if($errorFlag == false){
					$this->getResponse()
						->setHeader('result', 'PASS');
					$data = array();
					$data['email'] = $_POST['email'];
					$data['name'] = htmlentities($_POST['name'], ENT_QUOTES);
					$data['subject'] = htmlentities($_POST['subject'], ENT_QUOTES);
					//$data['message'] = htmlentities($_POST['message-input'], ENT_QUOTES);
					$data['message'] = $_POST['message-input'];
					$objContact = new Object_dbObj('contactus');
					$objContact->_new($data);
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Thank you...your message has been sent');
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
				*/
			default:
				break;
		}
    }

    public function userAction()
    {
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		$objUser = new Object_DbObj('user');
		switch($this->v['params']['val']){
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'login':
				$errors = array();
				$errorFlag = false;
				
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_RecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if (!$validatorChain->isValid($_POST['password'])){
					$errorFlag = true;
					$errors[] = array('label' => 'password', 'errors' => 'regex');
				}
				$login = new stdClass;
				$login->identity = $_POST['email'];
				$login->password = $_POST['password'];
				$this->v['auth']->_setAuthAdapter('users');
				$result = $this->v['auth']->_authenticate($login);
				//PROCESS
				if($result == false){
					$errorFlag = true;
					$errors[] = array('label' => 'authentication', 'errors' => 'authentication1');
				}		
				if($errorFlag == false){
					$this->getResponse()
						->setHeader('result', 'PASS');
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Login Successfull...');
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'forgotpassword':
				$errors = array();
				$errorFlag = false;
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_RecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');;
				}
				if($errorFlag == false){
					$token = rand(100000, 999999);
					$token_reason = 'password';
					$objUser->_setPayload(array('email' => trim($_POST['email'])));
					$success = $objUser->_updateData(array(
											array('category' => 'token', 'description' => 'token', 'value' => $token),
											array('category' => 'token', 'description' => 'reason', 'value' => $token_reason),
											));
					if($success == true){
						$data = new stdClass;
						$data->email = $_POST['email'];
						$data->token = $token;
						$data->token_reason = $token_reason;
						$mailSet = new Model_MailSetup();
						$mailObj = new Zend_Mail();
						$host = new Zend_Mail_Transport_Smtp( $mailSet->getHost(), $mailSet->getConfigInfo());
						$html = $this->view->partial('templates/emails/forgotpassword.phtml', 'default',  $data);
						$from = $mailSet->getFrom('contact');
						$to = $_POST['email'];
						$subj = "MySocialArea.com Password Reset";
						$mailObj->setBodyHtml($html);
						$mailObj->setFrom($from, 'MySocialArea.com Admin');
						$mailObj->addTo($to);
						$mailObj->setSubject($subj);
						$mailObj->send($host);
						$this->getResponse()->setHeader('result', 'PASS');
						$this->_helper->FlashMessenger
								->setNamespace('success')
								->addMessage('Please check your email address inbox for a token password reset and enter it on this page.');
					}
					else{
						$this->getResponse()
							->setHeader('result', 'FAIL');
						$errorFlag = true;
						$errors[] = array('label' => 'password', 'errors' => 'authentication2');;
						if(count($errors) > 0){
							echo Zend_Json::encode($errors);
						}
					}
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'password':
				$errors = array();
				$errorFlag = false;
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('password'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if(!$validatorChain->isValid($_POST['npassword'])){
					$errorFlag = true;
					$errors[] = array('label' => 'npassword', 'errors' => 'regex');;
				}
				if($_POST['cpassword'] != $_POST['npassword']){
					$errorFlag = true;
					$errors[] = array('label' => 'cpassword', 'errors' => 'identical');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('password'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if(!$validatorChain->isValid($_POST['curpassword'])){
					$errorFlag = true;
					$errors[] = array('label' => 'curpassword', 'errors' => 'regex');;
				}
				if($this->v['ident'] != NULL){
					$objUser->_setPayload(array('id' => $this->v['ident']->id));
					if(md5(trim($_POST['curpassword'])) == $objUser->_getGenDataItem('pwd')){
						$result = true;
					}
					else{
						$result = false;
					}
					//PROCESS
					if($result == false){
						$errorFlag = true;
						$errors[] = array('label' => 'authentication', 'errors' => 'authentication3');;
					}
				}
				else{
					$errorFlag = true;
					$errors[] = array('label' => 'general', 'errors' => 'general');;
				}
				if($errorFlag == false){
					$this->getResponse()
						->setHeader('result', 'PASS');
					$objUser->_editGeneral(array('pwd' => md5(trim($_POST['npassword']))));
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('SUCCESS...your password has been changed.');
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'resetpassword':
				$errors = array();
				$errorFlag = false;
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_RecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('password'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if(!$validatorChain->isValid($_POST['password'])){
					$errorFlag = true;
					$errors[] = array('label' => 'npassword', 'errors' => 'regex');;
				}
				if($_POST['cpassword'] != $_POST['password']){
					$errorFlag = true;
					$errors[] = array('label' => 'cpassword', 'errors' => 'identical');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('token'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 6)));
				if(!$validatorChain->isValid($_POST['token'])){
					$errorFlag = true;
					$errors[] = array('label' => 'token', 'errors' => 'regex');;
				}
				if($errorFlag == false){
					$object = $objUser->_setPayload(array('email' => trim($_POST['email'])));
					if($object != NULL && $objUser->_getDataItem('token', 'token') == $_POST['token'] && $objUser->_getDataItem('token', 'reason') == 'password'){
						$login = new stdClass;
						$login->identity = $_POST['email'];
						$login->password = $_POST['password'];
						$this->v['auth']->_setAuthAdapter('users');
						$result = $this->v['auth']->_authenticate($login);
						if($result == true){
							$success = $objUser->_deleteDataItem(array(
													array('category' => 'token', 'description' => 'token'),
													array('category' => 'token', 'description' => 'reason'),
													));
							$this->getResponse()
								->setHeader('result', 'PASS');
							$this->_helper->FlashMessenger()
									->setNamespace('success')
									->addMessage('Your password has been updated.');
						}
						else{
								$this->getResponse()
									->setHeader('result', 'FAIL');
								$errors[] = array('label' => 'authentication', 'errors' => 'authentication1');;
								if(count($errors) > 0){
									echo Zend_Json::encode($errors);
								}
						}
					}
					else{
						$this->getResponse()
							->setHeader('result', 'FAIL');
						$errors[] = array('label' => 'token', 'errors' => 'tokenverify');;
						if(count($errors) > 0){
							echo Zend_Json::encode($errors);
						}

					}
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'email':
				$errors = array();
				$errorFlag = false;
				
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_NoRecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['nemail'])){
					$errorFlag = true;
					$errors[] = array('label' => 'nemail', 'errors' => 'emailaddress');
				}
				if($_POST['cemail'] != $_POST['nemail']){
					$errorFlag = true;
					$errors[] = array('label' => 'cemail', 'errors' => 'identical');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_RecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['oemail'])){
					$errorFlag = true;
					$errors[] = array('label' => 'oemail', 'errors' => 'emailaddress');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if (!$validatorChain->isValid($_POST['password'])){
					$errorFlag = true;
					$errors[] = array('label' => 'password', 'errors' => 'regex');
				}
				$objUser->_setPayload(array('id' => $this->v['ident']->id));
				if(md5(trim($_POST['password'])) == $objUser->_getGenDataItem('pwd')){
					$result = true;
				}
				else{
					$result = false;
				}
				//PROCESS
				if($result == false){
					$errorFlag = true;
					$errors[] = array('label' => 'authentication', 'errors' => 'authentication2');;
				}
				if($errorFlag == false){
					$this->getResponse()
						->setHeader('result', 'PASS');
					$token = rand(100000, 999999);
					$token_reason = 'email';
					$data = new stdClass;
					$data->id = $this->v['ident']->id;
					$data->email = $_POST['nemail'];
					$data->token = $token;
					$data->token_reason = $token_reason;
					$objUser->_editGeneral(array('email' => trim($_POST['nemail'])));
					$success = $objUser->_updateData(array(
											array('category' => 'token', 'description' => 'token', 'value' => $token),
											array('category' => 'token', 'description' => 'reason', 'value' => $token_reason),
											));
					$mailSet = new Model_MailSetup();
					$mailObj = new Zend_Mail();
					$host = new Zend_Mail_Transport_Smtp( $mailSet->getHost(), $mailSet->getConfigInfo());
					$html = $this->view->partial('templates/emails/email.phtml', 'default',  $data);
					$from = $mailSet->getFrom('contact');
					$to =  $_POST['nemail'];
					$subj = "MySocialArea.com Email Address Change";
					$mailObj->setBodyHtml($html);
					$mailObj->setFrom($from, 'MySocialArea.com Admin');
					$mailObj->addTo($to);
					$mailObj->setSubject($subj);
					$mailObj->send($host);
					$this->_helper->FlashMessenger()
							->setNamespace('notice')
							->addMessage(	'A confrimation email has been sent to the new email address you just supplied.
											<br />
											When you receive that email please supply the token password in that email on this page to complete the change of email address process.');
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'confirmemail':
				$errors = array();
				$errorFlag = false;
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_RecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'nemail', 'errors' => 'emailaddress');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('password'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if(!$validatorChain->isValid($_POST['password'])){
					$errorFlag = true;
					$errors[] = array('label' => 'password', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('token'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 6)));
				if(!$validatorChain->isValid($_POST['token'])){
					$errorFlag = true;
					$errors[] = array('label' => 'token', 'errors' => 'regex');;
				}
				if($errorFlag == false){
					$object = $objUser->_setPayload(array('email' => trim($_POST['email'])));
					if($object != NULL && $objUser->_getDataItem('token', 'token') == $_POST['token'] && $objUser->_getDataItem('token', 'reason') == 'email'){
						$login = new stdClass;
						$login->identity = $_POST['email'];
						$login->password = $_POST['password'];
						$this->v['auth']->_setAuthAdapter('users');
						$result = $this->v['auth']->_authenticate($login);
						if($result == true){
							$success = $objUser->_deleteDataItem(array(
													array('category' => 'token', 'description' => 'token'),
													array('category' => 'token', 'description' => 'reason'),
													));
							$this->getResponse()
								->setHeader('result', 'PASS');
							$this->_helper->FlashMessenger()
									->setNamespace('success')
									->addMessage('Your email address has been updated.');
						}
						else{
								$this->getResponse()
									->setHeader('result', 'FAIL');
								$errors[] = array('label' => 'authentication', 'errors' => 'authentication1');;
								if(count($errors) > 0){
									echo Zend_Json::encode($errors);
								}
						}
					}
					else{
							$this->getResponse()
								->setHeader('result', 'FAIL');
							$errors[] = array('label' => 'token', 'errors' => 'tokenverify');;
							if(count($errors) > 0){
								echo Zend_Json::encode($errors);
							}

					}
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'personal':
				$errors = array();
				$errorFlag = false;
				$auth = Zend_Auth::getInstance();
				if($this->v['ident'] == NULL){
					$errorFlag = true;
					$errors[] = array('label' => 'general', 'errors' => 'general');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('username'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 10)));
				if (!$validatorChain->isValid($_POST['username'])){
					$errorFlag = true;
					$errors[] = array('label' => 'username', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('name'))));
				if (!$validatorChain->isValid($_POST['name'])){
					$errorFlag = true;
					$errors[] = array('label' => 'name', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Date());
				if (!$validatorChain->isValid($_POST['birthday'])){
					$errorFlag = true;
					$errors[] = array('label' => 'birthday', 'errors' => 'regex');;
				}
				if($errorFlag == false){
					$object = $objUser->_setPayload(array('id' => $this->v['ident']->id));
					if($objUser->_getDataItem('personal', 'username') == $_POST['username']
							&& $objUser->_getDataItem('personal', 'name') == $_POST['name']
							&& $objUser->_getDataItem('personal', 'birthday') == $_POST['birthday']){
						$this->getResponse()
							->setHeader('result', 'NOTHING');
					}
					else{
						$this->getResponse()->setHeader('result', 'PASS');
						$success = $objUser->_updateData(array(
												array('category' => 'personal', 'description' => 'username', 'value' => $_POST['username']),
												array('category' => 'personal', 'description' => 'name', 'value' => htmlentities($_POST['name'], ENT_QUOTES)),
												array('category' => 'personal', 'description' => 'birthday', 'value' => $_POST['birthday']),
												));
						if($success == true){
							$this->v['ident']->username = $_POST['username'];
						}
						$this->_helper->FlashMessenger
								->setNamespace('success')
								->addMessage('Your personal information has been updated');
					}
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
			case 'register':
				$errors = array();
				$errorFlag = false;
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_NoRecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');;
				}
				if($_POST['cemail'] != $_POST['email']){
					$errorFlag = true;
					$errors[] = array('label' => 'cemail', 'errors' => 'identical');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('name'))));
				if (!$validatorChain->isValid($_POST['name'])){
					$errorFlag = true;
					$errors[] = array('label' => 'name', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('username'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 10)));
				if (!$validatorChain->isValid($_POST['username'])){
					$errorFlag = true;
					$errors[] = array('label' => 'username', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Date());
				if (!$validatorChain->isValid($_POST['birthday'])){
					$errorFlag = true;
					$errors[] = array('label' => 'birthday', 'errors' => 'regex');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if (!$validatorChain->isValid($_POST['password'])){
					$errorFlag = true;
					$errors[] = array('label' => 'password', 'errors' => 'regex');;
				}
				if($_POST['cpassword'] != $_POST['password']){
					$errorFlag = true;
					$errors[] = array('label' => 'cpassword', 'errors' => 'identical');;
				}
				if(!array_key_exists('tou', $_POST)){
					$errorFlag = true;
					$errors[] = array('label' => 'tou', 'errors' => 'notempty');;
				}
				if(!array_key_exists('privacy', $_POST)){
					$errorFlag = true;
					$errors[] = array('label' => 'privacy', 'errors' => 'notempty');;
				}
				if($errorFlag == false){
					$token = rand(100000, 999999);
					$token_reason = 'new_user';
					$objUser->_new(array(
										'email' => trim($_POST['email']),
										'pwd' => md5(trim($_POST['password']))
									));
					$success = $objUser->_updateData(array(
											array('category' => 'personal', 'description' => 'username', 'value' => $_POST['username']),
											array('category' => 'personal', 'description' => 'name', 'value' => htmlentities($_POST['name'], ENT_QUOTES)),
											array('category' => 'personal', 'description' => 'birthday', 'value' => $_POST['birthday']),
											array('category' => 'token', 'description' => 'token', 'value' => $token),
											array('category' => 'token', 'description' => 'reason', 'value' => $token_reason),
											));
					////////////////////////////////
					$data = new stdClass;
					$data->email = $_POST['email'];
					$data->username = $_POST['username'];
					$data->name = $_POST['name'];
					$data->birthday = $_POST['birthday'];
					$data->password = $_POST['password'];
					$data->last_updated = date("Y-m-d H:i:s", time());
					$data->token = $token;
					$data->token_reason = $token_reason;
					if($success == true){
						$mailSet = new Model_MailSetup();
						$mailObj = new Zend_Mail();
						$host = new Zend_Mail_Transport_Smtp( $mailSet->getHost(), $mailSet->getConfigInfo());
						$html = $this->view->partial('templates/emails/signup.phtml', 'default',  $data);
						$from = $mailSet->getFrom( 'contact' );
						$to = $_POST['email'];
						$subj = "MySocialArea.com Registration";
						$mailObj->setBodyHtml($html);
						$mailObj->setFrom($from, 'MySocialArea.com Admin');
						$mailObj->addTo($to);
						$mailObj->setSubject($subj);
						$mailObj->send($host);
						$this->getResponse()->setHeader('result', 'PASS');
						$this->_helper->FlashMessenger
								->setNamespace('success')
								->addMessage('Please check your email address inbox for a token password reset and enter it on this page.');
					}
					else{
						$this->getResponse()
							->setHeader('result', 'FAIL');
						$errorFlag = true;
						if(count($errors) > 0){
							echo Zend_Json::encode($errors);
						}
					}
				}
				else{
					$this->getResponse()
						->setHeader('result', 'FAIL');
					if(count($errors) > 0){
						echo Zend_Json::encode($errors);
					}
				}
				break;
			case 'activate':
				$errors = array();
				$errorFlag = false;
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_EmailAddress());
				$validatorChain->addValidator(new Zend_Validate_Db_RecordExists(array('table' => 'user','field' => 'email')));
				if(!$validatorChain->isValid($_POST['email'])){
					$errorFlag = true;
					$errors[] = array('label' => 'email', 'errors' => 'emailaddress');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('password'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 20)));
				if(!$validatorChain->isValid($_POST['password'])){
					$errorFlag = true;
					$errors[] = array('label' => 'password', 'errors' => 'password');;
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('token'))));
				$validatorChain->addValidator(new Zend_Validate_StringLength(array('min' => 6, 'max' => 6)));
				if(!$validatorChain->isValid($_POST['token'])){
					$errorFlag = true;
					$errors[] = array('label' => 'token', 'errors' => 'regex');;
				}
				if($errorFlag == false){
					$object = $objUser->_setPayload(array('email' => trim($_POST['email'])));
					if($object != NULL && $objUser->_getDataItem('token', 'token') == $_POST['token'] && $objUser->_getDataItem('token', 'reason') == 'new_user'){
						$login = new stdClass;
						$login->identity = $_POST['email'];
						$login->password = $_POST['password'];
						$this->v['auth']->_setAuthAdapter('users');
						$result = $this->v['auth']->_authenticate($login);
						if($result == true){
							$success = $objUser->_deleteDataItem(array(
													array('category' => 'token', 'description' => 'token'),
													array('category' => 'token', 'description' => 'reason'),
													));
							$this->getResponse()
								->setHeader('result', 'PASS');
							$this->_helper->FlashMessenger()
									->setNamespace('success')
									->addMessage('CONGRATULATIONS! Registration process complete...Welcome to MySocialArea.com!.');
						}
						else{
							$this->getResponse()
								->setHeader('result', 'FAIL');
							$errors[] = array('label' => 'authentication', 'errors' => 'authentication1');;
							if(count($errors) > 0){
								echo Zend_Json::encode($errors);
							}
						}
					}
					else{
						$this->getResponse()
							->setHeader('result', 'FAIL');
						$errors[] = array('label' => 'token', 'errors' => 'tokenverify');;
						if(count($errors) > 0){
							echo Zend_Json::encode($errors);
						}
					}
				}
				else{
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

    }

    public function sheldontheoryAction()
    {
		$this->_helper->viewRenderer->setNoRender(true);
		//INSTANTIATE
		switch($this->v['params']['val']){
			//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
			case 'youtube':
				$recaptcha = new Model_Recaptcha();
				$errors = array();
				$errorFlag = false;
				$search = array('id' => $this->v['params']['id']);
				$obj = new Object_DbObj('sheldontheory');
				if($obj->_setPayload($search) == NULL){
					$errorFlag = true;
					$errors[] = array('label' => 'general', 'errors' => 'general');
				}
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator(new Zend_Validate_Regex(array('pattern' => $this->v['g']->_getRegex('alphanumericwithunderscore'))));
				$validatorChain->addValidator(new Zend_Validate_NotEmpty());
				if (!$validatorChain->isValid($_POST['youtube'])){
					$errorFlag = true;
					$errors[] = array('label' => 'youtube', 'errors' => 'regex');
				}
				$recapResult = $recaptcha->_isError($_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
				if ($recapResult == 'INVALID'){
					$errorFlag = true;
					$errors[] = array('label' => 'recaptcha', 'errors' => 'recaptcha');
				}
				if($errorFlag == false){
					$this->getResponse()
						->setHeader('result', 'PASS');
					$youtubeIdsUnSerialized = $obj->_getDataItem("youtube", "ids");
					$arrYouTubeIds = array();
					if( $youtubeIdsUnSerialized == NULL ){
						$arrYouTubeIds[] = $_POST['youtube'];
					}
					else{
						$arrYouTubeIds = unserialize($youtubeIdsUnSerialized);
						$arrYouTubeIds[] = $_POST['youtube'];
					}
					$obj->_updateData(array(
							array('category' => 'youtube', 'description' => 'ids', 'value' => serialize($arrYouTubeIds)),
					));
					$this->_helper->FlashMessenger
							->setNamespace('success')
							->addMessage('Thank you...link received. Ids: ' . unserialize($obj->_getDataItem("youtube", "ids")) );
				}
				else{
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
    }

    public function globalsAction()
    {
		$this->_helper->viewRenderer->setNoRender(true);
		$globals = array(
					'domain' => array(
										'full' => 'http://www.mysocialarea.com',
										'short' => 'mysocialarea.com',
										'name' => 'mysocialarea',
										'acronym' => 'mysa'
									),
						);
		echo Zend_Json::encode($globals);
    }

    public function indexAction()
    {
		$u = new Model_My_Utility();
		//CLEAN PARAMS AND SET SCRIPT PATH
		$params = $u->_cleanParams($this->_request->getParams());
		$table = new Zend_Db_Table('pss_picture');
		$data = array(
		'orientation' => $params['val'],
		);
		$where = $table->getAdapter()->quoteInto('id = ?', $params['id']);
		$table->update($data, $where);
        // action body
		//$u->dump($params);
    }

    public function defaultmlseletemhaveit1Action()
    {
		$mdl_U = new Model_My_Utility();
		$params = $mdl_U->_cleanParams($this->_request->getParams());
		$this->view->val = $params['val'];
    }

    public function psspages1Action()
    {
        // create new element
		$e = new Zend_Dojo_Form_Element_Editor('caption');
		$e->setLabel('Caption:');
        $e->setAttrib('style', 'width: 100%; height: 100%;');
        // add the element to the form
        $this->view->form = $e;
    }

    public function pssnewpage1Action()
    {
		$pssType = new Zend_Db_Table('pss_type');
		$types = Zend_Json::encode($pssType->fetchAll()->toArray());
		$this->view->types = $types;
		$flags = new stdClass();
		$flags->formCaption = 'All fields are required';
		$this->view->flags = $flags;
        $this->view->formVariables = 0;
    }

    public function psssearch1Action()
    {
		$u = new Model_My_Utility();
		//CLEAN PARAMS AND SET SCRIPT PATH
		$params = $u->_cleanParams($this->_request->getParams());
		$pssTable = new Zend_Db_Table('pss');
		if(array_key_exists('val', $params))
		{
			$pssRow = $pssTable->fetchRow('id = ' . $params['val']);
			$pssRow->description = html_entity_decode($pssRow->description);
			$pssPicTable = new Zend_Db_Table('pss_picture');
			$pssPicRows = $pssPicTable->fetchAll('pss_id = ' . $pssRow->id);
			$this->view->page = $pssRow;
			$this->view->pics = $pssPicRows;				
		}
    }

    public function pagesowner1Action()
    {
		$u = new Model_My_Utility();
		//CLEAN PARAMS AND SET SCRIPT PATH
		$params = $u->_cleanParams($this->_request->getParams());
		//NEED THIS TO GET PROPER EDITOR VALUE
		$rawParams = $this->_request->getParams();
		$pssTable = new Zend_Db_Table('pss');
		$data = array(
			'description' => htmlspecialchars($_POST['val'], ENT_QUOTES),
			);
			$where = $pssTable->getAdapter()->quoteInto('id = ?', $_POST['id']);
			$pssTable->update($data, $where);
			$this->view->result = 'Information has been saved';
		/*
		if(array_key_exists('id', $params) && array_key_exists('val', $params))
		{
			$data = array(
			'description' => $rawParams['val'],
			);
			$where = $pssTable->getAdapter()->quoteInto('id = ?', $params['id']);
			$pssTable->update($data, $where);
			$this->view->result = 'Information has been saved';
		}
		else
		{
			$this->view->result = 'Information could not be saved...Please try again.';
		}
		*/
    }

    public function pssgallery1Action()
    {
        $pssTable = new Zend_Db_Table('pss');
        $pssPictureTable = new Zend_Db_Table('pss_picture');
		$id;
    }

}





















