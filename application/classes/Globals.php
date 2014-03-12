<?php 
class Class_Globals
{
	protected $_globals = array(
		'attach_points' => array(
							'container' => 'l-template-container',
							'pane_center' => 'l-center',
							'content_default_1' => 'l-center-content',
							'content_admin_1' => 'l-center-content',
							'content_default_side_1' => 'l-center-side',
		),
		'attch_pts' => array(
			'admin' => array(
				'layout' => array(
					'container' => 'l-container',
					'menu_placeholder' => '.menu-placeholder',
					'panes' => array(
						'center' => 'l-pane-center'
					),
					'content' =>  array(
						'center' => 'l-content-center',
						'side' => 'l-content-side',
					),
					'header' => array(
						'holder' => 'l-header',
						'sub1' => 'l-header-sub1',
						'sub2' => 'l-header-sub2',
						'logo' => 'l-header-logo',
					),
				),
				'view' => array(
				),							
			),
			'default' => array(
				'layout' => array(
					'container' => 'l-template-container',
					'menu_placeholder' => '.menu-placeholder',
					'panes' => array(
						'center' => 'default-l-pane-center'
					),
					'content' =>  array(
						'center' => 'default-l-content-center',
						'side' => 'default-l-content-side',
					),
					'header' => array(
						'holder' => 'default-l-header',
						'sub1' => 'default-l-header-sub1',
						'sub2' => 'default-l-header-sub2',
						'logo' => 'default-l-header-logo',
					),
				),
				'view' => array(
				),							
			),
		),
		'constants' => array(
			'not_signed_in' => 'NOT_SIGNED_IN',
			'env' => array(
						'dev' => 'development',
						'prod' => 'production',
						),
			'errors' => array(
				'identity' => 'IDENTITY_ERROR',
			),
		),
		'css' => array(
			'bgc' => array(
				'html' => '#999999',
				'body' => '#FFFFFF',
			),
		),
		'domain' => array(
			'full' => 'http://www.mysocialarea.com',
			'short' => 'mysocialarea.com',
			'name' => 'mysocialarea',
			'acronym' => 'mysa'
		),
		'env' => APPLICATION_ENV,
		'regex' => array(
			'alphanumeric' => '/^[a-zA-Z0-9]*$/',
			'alphanumericwithunderscore' => '/^[a-zA-Z0-9_]*$/',
			'password' => '/^[\w-_]*$/',
			'name' => "/^\w+((-|'|\s)\w+)*/",
			'username' => "/^[\w]*$/",
			'token' => "/\d{6}/",
		),
	);
	
	function __construct()
	{
	}
	public function _getAll(){
		return $this->_globals;
	}

	public function _getAttachPts(){
		return $this->_globals['attch_pts'];
	}
	
	public function _getRegex($s)
	{
		return $this->_globals['regex'][$s];
	}
	
	public function _getRegexJS($s = NULL)
	{
		return rtrim(ltrim($this->_globals['regex'][$s], '/'), '/');
	}

	public function _getDomian($s = NULL)
	{
		return $this->_globals['domain'][$s];
	}

	public function _getConstant($s = NULL)
	{
		return $this->_globals['constants'][$s];
	}
}
?>