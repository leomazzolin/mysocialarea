<?php

class Admin_AjaxController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity())
		{
			$ident = $auth->getIdentity();
			if($ident->id == 1)
			{
				/*
				$this->_helper->layout->disableLayout();
				$ajaxContext = $this->_helper->getHelper('AjaxContext');
				$ajaxContext->addActionContext('index', 'html');
				$ajaxContext->addActionContext('ajax1', 'html');
				$ajaxContext->initContext();
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
        // action body
    }

    public function ajax1Action()
    {
		$u = new Model_My_Utility();
		//because won't work in init()
		$this->_helper->layout->disableLayout();
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
	    $ajaxContext->addActionContext('ajax1', 'html');
		$ajaxContext->initContext();

		$val = $this->_getParam('val');
		$mdl_Q = new Model_Questions();
		$mdl_QD = new Model_Questiondata();
		$mdl_S = new Model_Qotdsports();
		$row_Q = $mdl_Q->get_single($val);
		$rows_QD = $mdl_QD->get_choices($val);
		$row_ans = $mdl_QD->get_answer($val);
		$row_sport = $mdl_S->get_single($row_Q->sport_id);
		$this->view->row_Q = $row_Q;
		$this->view->rows_QD = $rows_QD;
		$this->view->row_ans = $row_ans;	
		$this->view->row_sport = $row_sport->sport;	
    }

    public function ajax2Action()
    {
		$this->_helper->layout->disableLayout();
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
	    $ajaxContext->addActionContext('ajax2', 'html');
		$ajaxContext->initContext();
		$val = $this->_getParam('val');

		$mdlUser = new Model_Users();
		$u = new Model_My_Utility();
		$this->view->personal = $mdlUser->_get(array('user_data' => array( 'id' => $val, 'desc' =>'personal')));
    }


}





