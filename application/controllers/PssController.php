<?php

class PssController extends Zend_Controller_Action
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

    }

    public function collageAction()
    {
		$auth = Zend_Auth::getInstance();		
		//INSTANTIATE
		$select = $this->v['t']['pss_picture']->select()->from('pss_picture',array('id', 'pss_id', 'orientation', 'extension'));
		$this->_rows['pss_picture'] = $this->v['t']['pss_picture']->fetchAll($select);
		$this->_rows['pss'] = $this->v['t']['pss']->fetchAll();
		$i = 0; $pic1 = array(); $pic2 = array(); $pic3 = array();
		foreach($this->_rows['pss_picture'] as $row)
		{
			if($i%3 == 0)
			{
				$pic1[] = $row->toArray();
			}
			else if($i%3 == 1)
			{
				$pic2[] = $row->toArray();
			}
			else
			{
				$pic3[] = $row->toArray();
			}
			$i++;
		}
		$this->view->pages = Zend_Json::encode($this->_rows['pss']->toArray());
		$this->view->pic1 = Zend_Json::encode($pic1);
		$this->view->pic2 = Zend_Json::encode($pic2);
		$this->view->pic3 = Zend_Json::encode($pic3);
    }

    public function pagesAction()
    {
		//INITIALIZE VARIABLES
		$varInits = new stdClass();
		$varInits->isSignedIn = false;
		$varInits->isPageRequest = false;

		//CHECK IDENDTITY STATUS
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
			$varInits->isSignedIn = true;
			$this->_rows['pss'] = $this->v['t']['pss']->fetchAll('user_id = ' . $identity->id);
			$this->view->pages = Zend_Json::encode($this->_rows['pss']->toArray());
			if(array_key_exists('user_id', $this->v['params']) && @$this->v['params']['user_id'] == $identity->id)
			{
				
				if(array_key_exists('page_id', $this->v['params']))
				{
					$this->_row['pss'] = $this->v['t']['pss']->fetchRow('id = ' . $this->v['params']['page_id']);
					$this->_row['pss']->description = html_entity_decode($this->_row['pss']->description);
					$this->_rows['pss_picture'] = $this->v['t']['pss_picture']->fetchAll('pss_id = ' . $this->_row['pss']->id);
					$varInits->isPageRequest = true;
					$this->view->page = Zend_Json::encode($this->_row['pss']->toArray());
					$this->view->pics = Zend_Json::encode($this->_rows['pss_picture']->toArray());				
				}
			}
		}
		
		$this->view->json = Zend_Json::encode(get_object_vars($varInits));
		$this->view->varInits = $varInits;
		if($varInits->isPageRequest == true)
		{
			$this->render('pagesowner');
		}
    }

    public function searchAction()
    {
		//ISTANTIATE
		$flags = new stdClass();
		$flags->showPage = false;
		
		//THIS GETS CALLED IF SOMEONE sELECTED A pICTURE FROM GALLERY
		if(array_key_exists('id', $this->v['params']))
		{
			$picture = $this->v['t']['pss_picture']->fetchRow('id = ' . $this->v['params']['id']);
			if($picture)
			{
				$this->_row['pss'] = $this->v['t']['pss']->fetchRow('id = ' . $picture->pss_id);
				$this->_row['pss']->description = html_entity_decode($this->_row['pss']->description);
				$this->_rows['pss_picture'] = $this->v['t']['pss_picture']->fetchAll('pss_id = ' . $this->_row['pss']->id);
				$this->view->page = $this->_row['pss'];
				$this->view->pics = $this->_rows['pss_picture'];
				$flags->showPage = true;
			}
		}
		
		//GET ALL PET PAGES
		$this->_rows['pss'] = $this->v['t']['pss']->fetchAll();
		//GET IDS OF ALL THE BREEDS
		$ids = array();
		foreach($this->_rows['pss'] as $row)
		{
			$ids[] = $row->type;	
		}
		$this->rows['pss_type_sub'] = $this->v['t']['pss_type_sub']->find($ids);
		//GET ALL THE TYPES THAT EXIST
		$ids = array();
		foreach($this->rows['pss_type_sub'] as $row)
		{
			$ids[] = $row->type_id;
			
		}
		$type_ids = array();
		$type_ids = array_unique($ids);
		$this->_rows['pss_type'] = $this->v['t']['pss_type']->find($type_ids);
		$json = array();
		$json[0] = array( 'id' => 'top', 'name' => 'All Pet Pages');
		//SET JSONTYPES
		foreach($this->_rows['pss_type'] as $row)
		{
			$json[] = array('id' => 'type-' . $row->id, 'name' => $row->pet_type, 'parent' => 'top');
		}
		foreach($this->rows['pss_type_sub'] as $row)
		{
			$json[] = array('id' => 'subtype-' . $row->id, 'name' => $row->desc, 'parent' => 'type-' . $row->type_id);
		}
		foreach($this->_rows['pss'] as $row)
		{
			$json[] = array('id' => $row->id, 'name' => $row->name . ' [' . $row->id . ']', 'parent' => 'subtype-' . $row->type);
		}
		$this->view->myJSON = Zend_Json::encode($json);
		$this->view->flags = $flags;

    }

    public function newpageAction()
    {
		//DOUBLE CHECK TO MAKE SURE USER IS SIGNED IN
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
		}
		else
		{
			$this->_redirect('/default/pss/pages');			
		}

		//INSTANTIATE
		$recaptcha = new Model_Recaptcha();

		//INITIALIZE FLAGS
		$flags = new stdClass();
		$flags->isError = false;
		$flags->formCaption = 'All fields are required';
		$flags->setBreeds = false;
		//MISC INITIALIZERS
		$this->view->initialPetTypeVal = 6;
		$types = Zend_Json::encode($this->v['t']['pss_type']->fetchAll()->toArray());
		$this->view->types = $types;
		$breeds = Zend_Json::encode($this->v['t']['pss_type_sub']->fetchAll()->toArray());
		$this->view->breeds = $breeds;
		
		if($this->_request->isPost())
		{
			if(array_key_exists('submit',$_POST))
			{
				$validatorChain = new Zend_Validate();
				$validatorChain->addValidator( new Zend_Validate_StringLength(array('min' => 1, 'max' => 10)))
               					->addValidator(new Zend_Validate_Alpha());
				if ($recaptcha->_isError($_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]) == false)
				{
				}
				else
				{
					$flags->formCaption = 'Please fill out ReCaptcha Field to prove you are human!!!';
					$flags->isError = true;
				}
				if ($validatorChain->isValid($_POST['name']))
				{
				}
				else
				{
					$flags->formCaption = 'ERROR: PLEASE START OVER';
					$flags->isError = true;
				}
				$fileManage = new Class_Filemanage1($_FILES);
				if ($fileManage->_restrictionsCheckOut() == false)
				{
			  	}
				else
				{
					$flags->formCaption = 'ERROR: PLEASE START OVER';
					$flags->isError = true;
				}
				if($flags->isError == false)
				{
					$data = array();
					$data['user_id'] = $identity->id; $data['name'] = $_POST['name']; $data['type'] = $_POST['breed']; $data['created'] = date("Y-m-d H:i:s", time());
					$pss_number = $this->v['t']['pss']->insert($data);
					$data = array(); $data['directory'] = 'pss'; $data['max_file_size'] = 5000000; $fileManage->_setPictureData($data);
					$data = array();
					$data['pss_id'] = $pss_number; $data['orientation'] = 0;$data['extension'] = $fileManage->_getFileExtension(); $data['created'] = date("Y-m-d H:i:s", time());
					$picture_number = $this->v['t']['pss_picture']->insert($data);
					if($picture_number)
					{
						$fileManage->_setPictureNumber($picture_number);
						$fileManage->_saveImage();
						$this->view->flags = $flags;
						$this->_helper->FlashMessenger()
								->setNamespace('success')
								->addMessage('You Have successfully created a new Pet Page...look for it in the list of options to the left.');
						$this->_redirect('default/pss/pages');

					}
					else
					{
						$flags->formCaption = 'Error please start over';
						$flags->isError = true;
						$this->view->flags = $flags;
					}
				}
				else
				{
					$this->view->formVariables = Zend_Json::encode($_POST);
					$this->view->flags = $flags;
				}
			}
			
		}
		else
		{
			$this->view->formVariables = 0;
			$this->view->flags = $flags;
		}
    }

    public function addpictureAction()
    {
		//DOUBLE CHECK TO MAKE SURE USER IS SIGNED IN
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
		}
		else
		{
			$this->_redirect('/default/pss/pages');			
		}

		//INSTANTIATE
		$u = new Model_My_Utility();
		$this->v['t']['pss'] = new Zend_Db_Table('pss');
		$this->v['t']['pss_picture'] = new Zend_Db_Table('pss_picture');
		$this->v['t']['pss_type'] = new Zend_Db_Table('pss_type');
		$this->v['t']['pss_type_sub'] = new Zend_Db_Table('pss_type_sub');
		$recaptcha = new Model_Recaptcha();

		//INITIALIZE FLAGS
		$flags = new stdClass();
		$flags->isError = false;
		$flags->formCaption = 'All fields are required';
		$flags->setBreeds = false;
		//MISC INITIALIZERS
		$this->view->initialPetTypeVal = 6;
		$types = Zend_Json::encode($this->v['t']['pss_type']->fetchAll()->toArray());
		$this->view->types = $types;
		$breeds = Zend_Json::encode($this->v['t']['pss_type_sub']->fetchAll()->toArray());
		$this->view->breeds = $breeds;
		
		//CHECK TO SEE IF USER IS THE OWNER
		$this->_row['pss'] = $this->v['t']['pss']->fetchRow('id = ' . $this->v['params']['page_id']);
		if($this->_row['pss']->user_id != $this->v['params']['user_id'])
		{
			$this->_helper->FlashMessenger()
					->setNamespace('error')
					->addMessage('An internal error occured...please continue from here.');
			$this->_redirect('default/pss/pages');
		}
		//CHECK TO SEE IF MAX PICTURES HAVE BEEN REACHED
		$select = $this->v['t']['pss_picture']->select()->where('pss_id = ?', $this->v['params']['page_id']);
		$this->_rows['pss_picture'] = $this->v['t']['pss_picture']->fetchAll($select);
		$count = $this->_rows['pss_picture']->count();
		if($count >= 10)
		{
			$this->_helper->FlashMessenger()
					->setNamespace('notice')
					->addMessage('You Have reached the maximum number of pictures that you can post for this pet page. 
									If you want to add this a new picture you must delete one that you have already uploaed.');
			$this->_redirect('default/pss/pages/user_id/' . $this->v['params']['user_id'] .'/page_id/'. $this->v['params']['page_id']);
		}
		if($this->_request->isPost())
		{
			if(array_key_exists('submit',$_POST))
			{
				//CHECK RECAPTCHA
				if ($recaptcha->_isError($_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]) == false)
				{
				}
				else
				{
					$flags->formCaption = 'Please fill out ReCaptcha Field to prove you are human!!!';
					$flags->isError = true;
				}
				//CHECK IMAGE UPLOAD OK
				$fileManage = new Class_Filemanage1($_FILES);
				if ($fileManage->_restrictionsCheckOut() == false)
				{
			  	}
				else
				{
					$flags->formCaption = 'ERROR: PLEASE START OVER';
					$flags->isError = true;
				}
				//CHECK To SEE IF USER_ID/PAGE_ID CHECK OUT
				$select = $this->v['t']['pss']->select()->where('user_id = ' . $identity->id )->where('id = ' . $this->v['params']['page_id']);
				$row = $this->v['t']['pss']->fetchRow($select);
				if($row)
				{
				}
				else
				{
					$flags->formCaption = 'ERROR: PLEASE START OVER';
					$flags->isError = true;
				}
				if ($fileManage->_restrictionsCheckOut() == false)
				{
			  	}
				else
				{
					$flags->formCaption = 'ERROR: PLEASE START OVER';
					$flags->isError = true;
				}
				if($flags->isError == false)
				{
					$data = array(); $data['directory'] = 'pss'; $data['max_file_size'] = 5000000; $fileManage->_setPictureData($data);
					$data = array();
					$data['pss_id'] = $this->v['params']['page_id']; $data['orientation'] = 0; $data['extension'] = $fileManage->_getFileExtension(); $data['created'] = date("Y-m-d H:i:s", time());
					$picture_number = $this->v['t']['pss_picture']->insert($data);
					if($picture_number)
					{
						$fileManage->_setPictureNumber($picture_number);
						$fileManage->_saveImage();
						$this->view->flags = $flags;
					}
					else
					{
						$flags->formCaption = 'Error please start over';
						$flags->isError = true;
						$this->view->flags = $flags;
					}
				}
				else
				{
					$this->view->formVariables = Zend_Json::encode($_POST);
					$this->view->flags = $flags;
				}
			}
		}
		else
		{
			$this->view->formVariables = 0;
			$this->view->flags = $flags;
		}
    }

    public function editpictureAction()
    {
		//INSTANTIATE
		$u = new Model_My_Utility();
		$files = array();
		//$form = new Form_Pss_Addpicture();
		$mdlPSS = new Model_Pss();
		$filemanager = new Class_Filemanage('pss');

		//INITIALIZE VARIABLES
		$varInits = new stdClass();
		$varInits->errormsg = NULL;
		
		//CHECK IF SIGNED IN
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
			//CHECK IF USER_ID PARAM MATCHES IDENTITY
			if($this->v['params']['user_id'] == $identity->id)
			{
				$row = $mdlPSS->_get($this->v['params']['page_id']);
				//CHECK IF PAGE EXISTS	
				if($row != NULL && @$row->user_id == $this->v['params']['user_id'])
				{
					$file = APPLICATION_PATH . '/../public/images/pss'. '/' . $this->v['params']['user_id'] . '-' .$this->v['params']['page_id'] . '-' . $this->v['params']['picture'] . '.jpg';
					if(file_exists($file))
					{
						$caption = new Zend_Dojo_Form_Element_Editor('caption');
						$caption->setLabel('Picture Caption:');
						$caption->setAttrib('style', 'width: 500px;');
						$this->view->caption = $caption;
						$this->view->picture = $row;
						$this->view->pictureNumber = $this->v['params']['picture'];
						
					}
				}
				else
				{
					$this->redirect('default/pss/index');
				}
			}
			else
			{
				$this->redirect('default/pss/index');
			}
		}
		else
			{
				$this->redirect('default/pss/index');
			}
    }

    public function feedbackAction()
    {
		
    }


}












