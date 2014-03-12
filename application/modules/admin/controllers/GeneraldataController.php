<?php

class Admin_GeneraldataController extends Zend_Controller_Action
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
				$menu = new Model_Menu();
				$layout->identity = true;
				$layout->email = $ident->email;
				$admin = $menu->get('admin');
				$qotd = $menu->get('admin_general');
				$layout->menu = $admin;
				$layout->submenu = $qotd;
				$layout->submenu_header = 'General Data: ';
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
        $form = new Admin_Form_Generaldata();
		$this->view->form = $form;
    }

    public function createAction()
    {
		$q = new Model_Generaldata();
        $form = new Admin_Form_Generaldata();
		if(isset($_POST['cancel'])){
			$this->_redirect('/admin/generaldata/index');
		}
		if ($this->_request->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$data = (object)$data;
				$q->create($data);
				$this->_redirect('/admin/generaldata/index');
			}
		}
		$this->view->form = $form;
    }


}



