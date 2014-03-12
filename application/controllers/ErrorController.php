<?php

class ErrorController extends Zend_Controller_Action
{

	protected $_reflectionClass = NULL;
	protected $_errorHandler = NULL;

    public function init()
    {
		foreach(Zend_Controller_Front::getInstance()->getRequest()->getParam('controllerVariables') as $key => $val){
			$this->v[$key] = $val;
		}
		Zend_Controller_Front::getInstance()->getRequest()->setParam('controllerVariables', NULL);
		$this->_reflectionClass = new Zend_Reflection_Class($this);
		$this->_errorHandler = new Class_Errorhandler();
    }

    public function errorAction()
    {
		$rMethod = new Zend_Reflection_Method(__METHOD__);
        $errors = $this->_getParam('error_handler');
		$payload = array(
							'errors' => NULL
						);
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
				$payload['errors']['message'] = 'Page not Found';
                //$this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
				$payload['errors']['message'] = 'Application error:<br />' . $errors->exception->getMessage();
                //$this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
			$payload['errors']['exception'] = $errors->exception;
            //$this->view->exception = $errors->exception;
        }
        
		$payload['errors']['exception'] = $errors->exception->getTraceAsString();
		$payload['errors']['request'] = $this->view->escape(var_export($errors->request->getParams(), true));
        //$this->view->request   = $errors->request;
		//Zend_Controller_Front::getInstance()->getRequest()->setParam('payload', $payload);
		$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $errors);
		//echo Zend_Json::encode($payload);

    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

