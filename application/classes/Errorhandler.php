<?php 
class Class_Errorhandler
{
	protected $_error = array();
	protected $_reflectionClass = NULL;
		
	function __construct()
	{
		$this->_error = Zend_Registry::get('errors');
		$this->_reflectionClass = new Zend_Reflection_Class($this);
	}

	public function _setError($class, $method, $error)
	{
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		try{
			switch($class->getName()){
				case 'ErrorController':
					$this->_error[] = array(
										'message' => $error->exception->getMessage(),
										'class' => $class->getName(),
										'method' => $method->getName(), 
										'exception' => $error->exception->getTraceAsString(),
										'request' => Zend_Json::encode($error->request->getParams()), 
										);
							
					break;
				default:
					$this->_error[] = array(
										'message' => $error->getMessage(),
										'class' => $class->getName(),
										'method' => $method->getName(), 
										'exception' => $error->getTraceAsString(),
										'request' => 'NIL', 
										);
			}
			Zend_Registry::set('errors', $this->_error);
		}
		catch (Exception $e) {
			$this->_error[] = array(
								'message' => $e->getMessage(),
								'class' => $this->_reflectionClass->getName(),
								'method' => $rMethod->getName(), 
								'exception' => $e->getTraceAsString(),
								);
			Zend_Registry::set('errors', $this->_error);
		}
	}
}
?>