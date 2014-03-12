<?php

class DojoController extends Zend_Controller_Action
{

    public function init()
    {
		$this->_helper->layout->disableLayout();
		$this->getHelper('viewRenderer')->setNoRender(true);		
    }

    public function indexAction()
    {

    }


}

