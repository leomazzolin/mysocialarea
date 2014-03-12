<?php

class Admin_OpController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$ident = $auth->getIdentity();
			if($ident->id == 1)
			{
				$layout = $this->_helper->layout();
				$formModule = new Form_Moduleselector();
				$formModule->_setOptions('admin');
				$formModule->getElement('layout_module')->setValue('/admin/op/index');
				$layout->moduleselector = $formModule;
				/*
				$menu = new Model_Menu();
				$layout->identity = true;
				$layout->email = $ident->email;
				$admin = $menu->get('admin');
				$layout->menu = $admin;
				*/
			}
			else
			{
				$this->_redirect('index/index/index');
			}
		}
		else
		{
			$this->_redirect('index/index/index');
		}
    }

    public function indexAction()
    {
		//SET UP TITLE
		$layout = $this->_helper->layout();
		$layout->title = 'OPINION POLLS HOME:';

		$mdlOpData = new Model_Op_Data();
		$mdlU = new Model_My_Utility();
		$polls = $mdlOpData->_getAll();
		if ($polls != NULL )
		{
			$poll_count = $polls->count();
		}else
		{
			$poll_count = 0;
		}
		$this->view->polls = $polls;
		$this->view->poll_count = $poll_count;
    }

    public function createAction()
    {
		$mdlU = new Model_My_Utility();
		$form = new Admin_Form_Poll();
		$mdlOpData = new Model_Op_Data();
		if ($this->_request->isPost())
		{
			if(isset($_POST['cancel'])){
				$this->_redirect('/admin/op/index');
				exit;
			}
			if ($form->isValid($_POST))
			{
				$data = (object) $form->getValues();
				$mdlOpData->_create($data);
				$this->_redirect('/admin/op/index');
			}
		}
		else
		{
			$this->view->form = $form;
		}
    }


}



