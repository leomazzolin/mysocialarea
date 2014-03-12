<?php

class Admin_DojoController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$ident = $auth->getIdentity();
			if($ident->id == 1)
			{
				$this->_helper->layout->disableLayout();
				$this->getHelper('viewRenderer')->setNoRender(true);		
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
        // action body
    }


}

