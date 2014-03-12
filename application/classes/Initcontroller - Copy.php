<?php 
class Class_Initcontroller
{
	protected $_uri = NULL;
	protected $_params = array();
	protected $_title = NULL;
	protected $_titleDivider = '...';
	
	
	function __construct($uri = NULL, $params = NULL)
	{
		if($uri != NULL)
		{
			$this->_setURI($uri);
		}
		if($params != NULL)
		{
			$this->_setParams($params);
			$this->_setTitle();
		}
	}
	
	protected function _setTitle()
	{
		switch ($this->_params['module'])
		{
			case 'default':
				$this->_title = '';
				switch ($this->_params['controller'])
				{
					case 'index':
						$this->_title = $this->_title . '';
						switch ($this->_params['action'])
						{
							case 'index':
							  $this->_title = $this->_title . 'WELCOME TO MYSOCIALAREA.COM!!!';
							  break;
							default:
							  $this->_title = $this->_title . '';
							  break;
						} 	
					 	break;
					case 'user':
						$this->_title = 'MY PROFILE' . $this->_titleDivider;
						switch ($this->_params['action'])
						{
							case 'index':
							  $this->_title = $this->_title . 'overview';
							  break;
							case 'signup':
							  $this->_title = $this->_title . 'signup';
							  break;
							case 'activate':
							  $this->_title = $this->_title . 'account activation';
							  break;
							case 'login':
							  $this->_title = $this->_title . 'login';
							  break;
							case 'logout':
							  $this->_title = $this->_title . 'logout';
							  break;
							case 'email':
							  $this->_title = $this->_title . 'edit email';
							  break;
							case 'confirmemail':
							  $this->_title = $this->_title . 'confirm email';
							  break;
							case 'personal':
							  $this->_title = $this->_title . 'edit personal details';
							  break;
							case 'password':
							  $this->_title = $this->_title . 'edit password';
							  break;
							case 'forgotpassword':
							  $this->_title = $this->_title . 'forgot my password';
							  break;
							case 'resetpassword':
							  $this->_title = $this->_title . 'reset password';
							  break;
							case 'register':
							  $this->_title = $this->_title . 'register';
							  break;
							default:
							  $this->_title = $this->_title . '';
							  break;
						} 	
						break;
					case 'contact':
					  $this->_title = 'CONTACT US' . $this->_titleDivider;
						switch ($this->_params['action'])
						{
							case 'index':
							  $this->_title = $this->_title . '';
							  break;
							default:
							  $this->_title = $this->_title . '';
							  break;
						} 	
					  break;
					case 'help':
					  $this->_title = 'HELP' . $this->_titleDivider;
						switch ($this->_params['action'])
						{
							case 'index':
							  $this->_title = $this->_title . 'overview';
							  break;
							case 'privacy':
							  $this->_title = $this->_title . 'privacy policy';
							  break;
							case 'tou':
							  $this->_title = $this->_title . 'terms of use';
							  break;
							default:
							  $this->_title = $this->_title . '';
							  break;
						} 	
					  break;
					case 'pss':
						$this->_title = 'PET SOCIAL SPACE' . $this->_titleDivider;
						switch ($this->_params['action'])
						{
							case 'index':
							  $this->_title = $this->_title . 'overview';
							  break;
							case 'collage':
							  $this->_title = $this->_title . 'photo gallery';
							  break;
							case 'pages':
							  $this->_title = $this->_title . 'your pet pages';
							  break;
							case 'search':
							  $this->_title = $this->_title . 'page search';
							  break;
							case 'newpage':
							  $this->_title = $this->_title . 'create a new page';
							  break;
							case 'addpicture':
							  $this->_title = $this->_title . 'add a picture';
							  break;
							case 'editpicture':
							  $this->_title = $this->_title . 'edit picture';
							  break;
							case 'feedback':
							  $this->_title = $this->_title . 'feedback';
							  break;
							default:
							  $this->_title = $this->_title . '';
							  break;
						} 	
					  break;
					default:
					  $this->_title = '';
					  break;
				} 	
				break;
			default:
				$this->_title = '';
				break;
		} 	
	}
	
	public function _setURI($uri)
	{
		$this->_uri = $this->_cleanURI($uri);
	}

	public function _setParams($params)
	{
		$this->_params = $this->_cleanParams($params);
	}
	
	public function _getURI()
	{
		return $this->_uri;
	}

	public function _getParams()
	{
		return $this->_params;
	}

	public function _getTitle()
	{
		return $this->_title;
	}
		
	protected function _cleanURI($uri)
	{
		return strip_tags(trim($uri));
	}

	protected function _cleanParams($params)
	{
		$p = array();
		foreach($params as $key => $value)
		{
			$p[$key] = str_replace( ' ', '', strip_tags(trim($value)));
		}
		return $p;
	}

}
?>