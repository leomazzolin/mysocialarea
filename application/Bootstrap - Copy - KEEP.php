<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
	protected $_globals = array();
	
	protected $payloadLayout = array(
										'globals' => NULL,
										'identity' => NULL,
										'triggers' => NULL,
										'attachpts' => NULL,
										//'jsonIdentity' => NULL,
										);
	protected $payloadView = array(
										'forms' => NULL,
										'triggers' => NULL,
										'attachpts' => NULL,
										'extras' => NULL,
										);
	

	protected function _initPHPSettings() { 
        date_default_timezone_set('America/Toronto'); 
	}

    protected function _initAutoload ()
    {
        // Add autoloader empty namespace
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        //$autoLoader->registerNamespace('Facebook_');
        //$autoLoader->registerNamespace('Twitter_');
        //$autoLoader->registerNamespace('Msa_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(
			array(
					'basePath' => APPLICATION_PATH ,
					'namespace' => '' ,
					'resourceTypes' => array(	
											'form' => array(
												'path' => 'forms/' ,
												'namespace' => 'Form_'
											),
											'model' => array(
												'path' => 'models/',
												'namespace' => 'Model_'
											),
											'class' => array(
												'path' => 'classes/',
												'namespace' => 'Class_'
											),
											'object' => array(
												'path' => 'objects/',
												'namespace' => 'Object_'
											),
											'collection' => array(
												'path' => 'collections/',
												'namespace' => 'Collection_'
											),
											'interface' => array(
												'path' => 'Interfaces/',
												'namespace' => 'Interface_'
											),
				)
			)
		);
        // Return it so that it can be stored by the bootstrap
        return $autoLoader;
    }
	
	protected function _initSetApplicationOptions() {
       Zend_Registry::set("appOptions", $this->getOptions());
    }

	protected function _initBootstrapDataTypes() {
		$globals = new Class_Globals();
		$this->_globals = $globals->_getAll();
		$this->payloadLayout['globals'] = $globals->_getAll();
    }

	protected function _initDefaultDb() {
   		$config = Zend_Registry::get('appOptions');
		$db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }

	protected function _initIdentity(){
		$view = new Zend_View();
		$view->layout()->_identity = NULL;
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()){
			$identity = $auth->getIdentity();
			switch($identity->userType)
			{
				//GENERAL CONTACT SUBMISSION IN CONTACT/INDEX
				case 'users':
					$user = array( 'id' => $identity->id );
					$mdlUser = new Object_User($user);
					$token = $mdlUser->_getCategory('token');
					if(array_key_exists('reason', $token))
					{
						if($token['reason'] == 'new_user')
						{
							$view->layout()->_identity = '/user/activate';
						}
						if($token['reason'] == 'password')
						{
							$view->layout()->_identity = '/user/resetpassword';
						}
						if($token['reason'] == 'email')
						{
							$view->layout()->_identity = '/user/confirmemail';
						}
					}
					else
					{
						$this->payloadLayout['identity'] = $identity;
						//$this->payloadLayout['identity'] = $this->payloadLayout['globals']['constants']['errors']['identity'];
					}
					break;
				case 'admins':
					$this->payloadLayout['identity'] = $identity;
					break;
				default:
					$this->payloadLayout['identity'] = NULL;
					//$this->payloadLayout['jsonIdentity'] = $this->_globals['constants']['not_signed_in'];
					break;
			}
		}else{
			$this->payloadLayout['identity'] = NULL;
			//$this->payloadLayout['jsonIdentity'] = $this->_globals['constants']['not_signed_in'];
		}
	}

	public function _initPlugins(){
		
		$this->bootstrap('frontController');
		Zend_Controller_Action_HelperBroker::addHelper(new ModuleLayoutLoader());
		$front = Zend_Controller_Front::getInstance();
		$front->setRouter(new Zend_Controller_Router_Rewrite())
			  ->registerPlugin(new Msa_Controller_Plugin_Abstract());
	}
	
	public function _initRoutes()
	{
	
		$this->bootstrap('frontController');
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
	
	  // Specifying the \"api\" module only as RESTful:
		$restRoute = new Zend_Rest_Route($front, array(), array(
			'Rest',
		));
		$router->addRoute('rest', $restRoute);
	
	}
				
	protected function _initModuleautoload() {
	  $autoloader = new Zend_Application_Module_Autoloader ( array ('namespace' => '', 'basePath' => APPLICATION_PATH ) );
	  return $autoloader;
	}
	
	protected function _initAutoLoadModuleAdmin() {
		$autoloader = new Zend_Application_Module_Autoloader(array(
				'namespace' => 'Admin',
				'basePath' => APPLICATION_PATH . '/modules/admin'
		));
		return $autoloader;
	}

	public function _initModuleControllers()
	{
		$this->bootstrap('frontController');
		$front = Zend_Controller_Front::getInstance();
		$front->addModuleDirectory(APPLICATION_PATH . '/modules/admin/', 'admin');
	}

    protected function _initView ()
    {
        // Initialize view
        $view = new Zend_View();
        //$view->doctype('HTML5');
		$view->doctype(Zend_View_Helper_Doctype::XHTML1_RDFA);
		
        $view->headTitle('MySocialArea.com');
		
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
                 		->appendHttpEquiv('Content-Language', 'en-US');
		//$view->headMeta()->setCharset('UTF-8');
		$view->headMeta()->appendName('keywords', 'Social Networking, friends, interaction');
		$view->headMeta()->appendName('title', 'MySocialArea.com');
		$view->headMeta()->appendName('description', 'MySocialArea.com content is designed to be fun and light hearted with the ability to share and discuss with your social media friends 
							such as Facebook and Twitter although you do not need an account for either.
							MySocialArea.com content also evolves to individual user preferences by accepting user suggestions.');
		$view->headMeta()->setProperty('og:title', 'MySocialArea.com');
		$view->headMeta()->setProperty('og:site_name', 'MySocialArea');
		//$view->headMeta()->setProperty('og:url', 'my article title');
		$view->headMeta()->setProperty('og:type', 'website');
		$view->headMeta()->setProperty('og:description', 'MySocialArea.com content is designed to be fun and light hearted with the ability to share and discuss with your social media friends 
															such as Facebook and Twitter although you do not need an account for either.
															MySocialArea.com content also evolves to individual user preferences by accepting user suggestions.');
		$view->headMeta()->setProperty('og:image', 'http://mysocialarea.com/images/website_logo.jpg');
		$view->headMeta()->setProperty('og:admins', '100002846966904');
		$view->headMeta()->setProperty('og:app_id', '188317251310377');

		$view->headLink(array('rel' => 'shortcut icon', 'href' => '/images/website_logo.jpg', 'type' => 'image/x-icon'));
		$view->headLink(array('rel' => 'canonical', 'href' => 'http://www.mysocialarea.com'));
		$view->headLink()->appendStylesheet('/css/layout.css');
		$view->headLink()->appendStylesheet('/dojo/dijit/themes/claro/claro.css');
		
		$view->headScript()->appendFile('/scripts/prototypes/banner.js');
		$view->headScript()->appendFile('/scripts/prototypes/DrawImage1.js');
		$view->headScript()->appendFile('/scripts/facebook/like.js');
		$view->headScript()->appendFile('/scripts/twitter/follow.js');
		
		/*
		JQUERY STUFF
		JQUERY UI STYLE SHEETS
		$view->headLink()->appendStylesheet('/jquery/smoothness/jquery-ui-1.10.2.custom.min.css');
		$view->headLink()->appendStylesheet('/jquery/smoothness/js-custom.css');
		JQUERY TABLESORTER STYLE SHEET
		$view->headLink()->appendStylesheet('/jquery/addons/tablesorter/blue-table-sort.css');
		
		JQUERY SOURCE FILES
		$view->headScript()->appendFile('/jquery/jquery-1.9.1.js');
		$view->headScript()->appendFile('/jquery/jquery-ui-1.10.2.custom.min.js');
		JQUERY ADDONS
		$view->headScript()->appendFile('/jquery/addons/tablesorter/jquery.tablesorter.js');
		$view->headScript()->appendFile('/jquery/addons/timepicker/jquery-ui-timepicker-addon.js');
		SET UP JQUERY
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$view->jQuery()->addStylesheet('/jquery/smoothness/jquery-ui-1.10.2.custom.min.css')
						  ->setLocalPath('/jquery/jquery-1.9.1.js')
						  ->setUiLocalPath('/jquery/jquery-ui-1.10.2.custom.min.js');
		END JQUERY STUFF */
		
		/*
		SET UP DOJO
		$view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
		*/
		
		
		$view->layout()->payloadBootstrap = $this->payloadLayout;
		$view->payloadView = $this->payloadView;
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        return $view;
    }
	
	
	/*
	protected function _initJsonEncodPayload() {
		$view = new Zend_View();
		$view->layout()->payloadBootstrap = Zend_Json::encode($this->payloadLayout);
		//$view->payloadView = Zend_Json::encode($this->payloadView);
        //$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		//$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		//$viewRenderer->setView($view);
		//Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        //return $view;
    }
	*/
	/*
	protected function _initLayoutHelper()
	{
		$this->bootstrap('frontController');
		$layout = Zend_Controller_Action_HelperBroker::addHelper(new ModuleLayoutLoader());
	}
	*/
}


//FOR SETTING DEFAULT LAYOUT FOR DIFFERENT MODULES
class ModuleLayoutLoader extends Zend_Controller_Action_Helper_Abstract
// looks up layout by module in application.ini
{
    public function preDispatch()
    {
        $bootstrap = $this->getActionController()
                          ->getInvokeArg('bootstrap');
        $config = $bootstrap->getOptions();
        $module = $this->getRequest()->getModuleName();
		
        if (isset($config[$module]['resources']['layout']['layout'])) {
            $layoutScript = $config[$module]['resources']['layout']['layout'];
            $this->getActionController()
            ->getHelper('layout')
            ->setLayout($layoutScript);
        }
    }
}