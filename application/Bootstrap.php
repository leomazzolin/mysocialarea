<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
	protected $_globals = array();

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
    }

	protected function _initDefaultDb() {
   		$config = Zend_Registry::get('appOptions');
		$db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }

	protected function _initErrorRegistry() {
   		Zend_Registry::set('errors', array());
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
		$view->headMeta()->appendName('keywords', 'Social Networking, friends, interaction, Big Bang Theory, fun');
		$view->headMeta()->appendName('title', 'MySocialArea.com');
		$view->headMeta()->appendName('description', 'Providing thought provoking fun content that can be discussed with your social friends.');
		$view->headMeta()->setProperty('og:title', 'MySocialArea.com');
		$view->headMeta()->setProperty('og:site_name', 'MySocialArea');
		$view->headMeta()->setProperty('og:url', 'http://www.mysocialarea.com');
		$view->headMeta()->setProperty('og:type', 'website');
		$view->headMeta()->setProperty('og:description', 'Providing thought provoking fun content that can be discussed with your social friends.');
		$view->headMeta()->setProperty('og:image', 'http://mysocialarea.com/images/website_logo.jpg');
		$view->headMeta()->setProperty('fb:admins', '100002846966904');
		$view->headMeta()->setProperty('fb:app_id', '188317251310377');

		$view->headLink(array('rel' => 'shortcut icon', 'href' => '/images/website_logo.jpg', 'type' => 'image/x-icon'));
		$view->headLink(array('rel' => 'canonical', 'href' => 'http://www.mysocialarea.com'));
		$view->headLink()->appendStylesheet('/css/layout.css');
		//$view->headLink()->appendStylesheet('/dojo/dijit/themes/claro/claro.css');
		
		//$view->headScript()->appendFile('/scripts/prototypes/banner.js');
		//$view->headScript()->appendFile('/scripts/prototypes/DrawImage1.js');
		//$view->headScript()->appendFile('/scripts/facebook/like.js');
		$view->headScript()->appendFile('/scripts/twitter/follow.js');
				
		//$view->layout()->payloadBootstrap = $this->payloadLayout;
		//$view->payloadView = $this->payloadView;
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        return $view;
    }

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