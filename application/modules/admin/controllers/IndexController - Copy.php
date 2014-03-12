<?php

class Admin_IndexController extends Zend_Controller_Action
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
				$formModule->getElement('layout_module')->setValue('/admin/index/index');
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
		$layout->title = 'ADMIN HOME:';
		
		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		$this->_helper->layout->disableLayout();
		$u = new Model_My_Utility();
		$final = array();
		header('content-type: text/plain');
		$http = 'http://en.wikipedia.org/wiki/Category:Birds_kept_as_pets';
		$string = file_get_contents($http);
		
		$string = strstr($string, '<ul><li><a href="/wiki/African_Grey_Parrot" title="African Grey Parrot">African Grey Parrot</a></li>');
		$array = preg_split('/<\/tr><\/table><\/div>/', $string);
		$string = $array[0];
		$string = str_replace('</a>', '', $string);
		$string = str_replace('<ul>', '', $string);
		$string = str_replace('<li>', '', $string);
		$string = trim(str_replace('List of Amazon parrots</li>', '', $string));
		preg_match_all('/<a(.*?)>/', $string, $match);
		$match = array_unique($match[0]);
		foreach($match as $m)
		{
			$string = str_replace($m, '', $string);
		}		
		preg_match_all('/<\/ul(.*?)\/h3>/', $string, $match);
		$match = array_unique($match[0]);
		foreach($match as $m)
		{
			$string = str_replace($m, '', $string);
		}		
		preg_match_all('/<td(.*?)\/h3>/', $string, $match);
		$match = array_unique($match[0]);
		foreach($match as $m)
		{
			$string = str_replace($m, '', $string);
		}		
		$final = array();
		$final = explode('</li>', $string);
		array_pop($final);

		/*
		$array = preg_split('/<tr class="sortbottom">/', $string);
		$string = $array[0];
		$string = str_replace('</a>', '', $string);
		$string = str_replace('<td>', '', $string);
		$string = str_replace('<tr>', '', $string);
		$string = str_replace('</span>', '', $string);
		preg_match_all('/<a(.*?)>/', $string, $match);
		$match = array_unique($match[0]);
		foreach($match as $m)
		{
			$string = str_replace($m, '', $string);
		}
		preg_match_all('/<span(.*?)>/', $string, $match);
		$match = array_unique($match[0]);
		foreach($match as $m)
		{
			$string = str_replace($m, '', $string);
		}
		$array = explode('</tr>', $string);
		array_pop($array);
		$final = array();
		foreach($array as $a)
		{
			$final[] = explode('</td>', $a);
		}
		*/
		
		$table = new Zend_Db_Table('pss_type_sub');
		foreach($final as $f)
		{
			$insert = array();
			$insert['type_id'] = 3; $insert['desc'] = trim($f);
			//$u->dump($insert);
			//$table->insert($insert);			
		}
		
		//$u->dump($string);
		//$u->dump($array);
		//$u->dump($final);
    }


}

