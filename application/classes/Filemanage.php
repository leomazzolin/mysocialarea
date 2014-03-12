<?php
class Class_Filemanage
{
	protected $_filepath;
	
	function __construct($path = NULL)
	{
		switch ($path)
		{
		case 'pss':
		  $this->_filepath = APPLICATION_PATH . '/../public/images/pss';
		  break;
		default:
		  throw new Zend_Exception("Please specify a path when instantiating a Filemanage object");
		}
	}
	
	public function _checkDirExists($user_id, $page_id)
	{
		$dir = $this->_filepath . '/' . $user_id;

		// Open a known directory, and proceed to read its contents
		if (is_dir($dir))
		{
			$dir = $dir . '/' . $page_id;
			if (is_dir($dir))
			{
				return $dir;	
			}
			else
			{
				mkdir($dir);
				return $dir;
			}
			
		}
		else
		{
			mkdir($dir);
			$dir = $dir . '/' . $page_id;
			if (is_dir($dir))
			{
				return $dir;	
			}
			else
			{
				mkdir($dir);
				return $dir;
			}
		}
	}

	public function _setPSSPictureNumber($data)
	{
		$u = new Model_My_Utility();
		for($i=1; $i<=10; $i++)
		{
			if(!file_exists($this->_filepath . '/' . $data['user_id'] . '-' . $data['page_id'] . '-' . $i . '.jpg'))
			{
				$u->dump($data);
				return $i;
				exit;
			}
		}
	}
	

}
?>