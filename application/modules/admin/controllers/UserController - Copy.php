<?php

class Admin_UserController extends Zend_Controller_Action
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
				$formModule->getElement('layout_module')->setValue('/admin/user/index');
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
		$layout->title = 'USER HOME:';
		$mdlUser = new Model_Users();
		$u = new Model_My_Utility();
		$users = $mdlUser->_get();
		$json = Zend_Json::encode($users->toArray());
		$this->view->myjson = Zend_Json::prettyPrint($json, array("indent" => " "));
		$this->view->users = $users;
    }


}

