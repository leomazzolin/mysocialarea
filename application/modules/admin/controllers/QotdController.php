<?php

class Admin_QotdController extends Zend_Controller_Action
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
				$qotd = $menu->get('admin_qotd');
				$layout->menu = $admin;
				$layout->submenu = $qotd;
				$layout->submenu_header = 'Sports Question of the Day: ';
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
		$mdl_Q = new Model_Questions();
		$mdl_QD = new Model_Questiondata();
		$mdl_U = new Model_My_Utility();
		$mdl_QData = new Model_Qotd_Data();
		$q_count = $mdl_Q->item_count();
		$this->view->q_count = $q_count;
		$this->view->sport_info = $mdl_Q->get_sport_bkdwn();
		$mdl_QData->calc_stats();
    }

    public function createAction()
    {
		$q = new Model_Questions();
        $form = new Admin_Form_Question();
		$form->setup_create_action();
		if(isset($_POST['cancel'])){
			$this->_redirect('/admin/qotd/index');
		}
		if ($this->_request->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$data['close_time'] = substr($data['close_time'], 1);
				$data = (object)$data;
				$q->create($data);
				$this->_redirect('/admin/qotd/index');
			}
		}
		$this->view->form = $form;
    }

    public function editAction()
    {
		$mdl_Q = new Model_Questions();
		$mdl_QD = new Model_Questiondata();
        $form = new Admin_Form_Question();
		$mdl_U = new Model_My_Utility();
		
		if(isset($_POST['cancel'])){
			$this->_redirect('/admin/qotd/index');
		}
		
		$id = $this->_request->getParam('id');
		$q = $mdl_Q->get_single($id);
		if($q != NULL)
		{
			$q_d = $mdl_QD->get_choices($id);
			$sport = $mdl_QD->get_sport($id);
			$form->populate_req($q);
			$form->populate_not_req($q_d);
			$form->populate_sport($sport);
		}
		
		if ($this->_request->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$data['close_time'] = substr($data['close_time'], 1);
				$data = (object)$data;
				$mdl_Q->updateQuestion($data);
				$this->_redirect('/admin/qotd/view');		
			}
		}
		$this->view->form = $form;
    }

    public function viewAction()
    {
		//params
		//instantiate
		$form = new Admin_Form_Filter_Question();
		$mdl_Q = new Model_Questions();
		$u = new Model_My_Utility();
		if ($this->_request->isPost() && !isset($_POST['cancel']))
		{
			if ($form->isValid($_POST))
			{
				
				$data = $form->getValues();
				$data_formatted = $data;
				$data_formatted['month'] = $form->format_month($data_formatted['month']);
				$data = (object)$data;
				$data_formatted = (object)$data_formatted;
				$rows_q = $mdl_Q->filter_year_month($data_formatted);
				$row_count = $u->row_count($rows_q);
				$form->getElement('year')->setValue($data_formatted->year);
				$form->getElement('month')->setValue($data_formatted->month);
			}
		}
		else
		{
			$rows_q = $mdl_Q->get_all();
			$row_count = $u->row_count($rows_q);
		}
		$this->view->form = $form;
		$this->view->rows_q = $rows_q;
		$this->view->row_count = $row_count; 
    }

    public function deleteAction()
    {
		$mdl_Q = new Model_Questions();
		$u = new Model_My_Utility();
		$id = $this->_request->getParam('id');
		$mdl_Q->deleteQuestion($id);
		$this->_redirect('/admin/qotd/view');		
    }

    public function answerAction()
    {
		$first_monday = '2012-09-24';
        $form = new Admin_Form_Answer();
		$mdl_Q = new Model_Questions();
		$mdl_QD = new Model_Questiondata();
		$mdl_U = new Model_My_Utility();
		$mdl_UA = new Model_Useranswers();
		$id = $this->_request->getParam('id');
		$form->getElement('id')->setValue($id);
		$q = $mdl_Q->get_single($id);
		if ($this->_request->isPost())
		{
			if ($form->isValid($_POST))
			{
				if(isset($_POST['cancel']))
				{
					$this->_redirect('/admin/qotd/view');
				}
				else
				{
					$form_data = $form->getValues();
					$data = new stdClass;
					$data->question_id = $id;
					$data->description = 'answer';
					$data->value = strtolower($form_data['answer']);
					$mdl_QD->answer($data);
					$mdl_UA->mark_useranswer($data);
					$this->_redirect('/admin/qotd/view');		
				}
			}
		}
		$this->view->question = $q;
		$this->view->form = $form;
    }

    public function markAction()
    {
		$first_monday = '2012-09-24';
        $form = new Admin_Form_Mark();
		$mdl_U = new Model_My_Utility();
		$mdl_Q = new Model_Questions();
		$mdl_UQS = new Model_Qotduserstatsweekly();
		$mdl_User = new Model_Users();
		$mdl_UA = new Model_Useranswers();
		if ($this->_request->isPost())
		{
			if ($form->isValid($_POST))
			{
				if(isset($_POST['cancel']))
				{
					$this->_redirect('/admin/qotd/view');
				}
				else
				{
					$form_data = $form->getValues();
					if($form_data['choices'] == 'last')
					{
					}
					elseif($form_data['choices'] == 'single')
					{
						$date = $this->_request->getParam('monday_date');
						$question_data = $mdl_Q->get_week_answers($date);
						if(count($question_data) == 7)
						{
							$user_answers = $mdl_User->get_week_answers($question_data);
							foreach($user_answers as $user)
							{
								$i = 0;						
								foreach($question_data as $q_d)
								{
									if($user->answers[$q_d->question_id]->answer == $q_d->answer)
									{
										$i += 1;
									}
								}
								$input = new stdClass;
								$input->user_id = $user->id;
								$input->monday_date = $date;
								$input->value = $i;
								$mdl_UQS->mark_row($input);
							}
							
						}
						else
						{
							//flash message error
						}
					}
					else
					{
						
					}
				}
			}
		}
		else
		{
		}
		$this->view->form = $form;
    }


}













