<?php
class Class_Filemanage1
{
	protected $_filepath;
	protected $_data;
	protected $_file;
	
	function __construct($file = NULL)
	{
		$this->_file = $file;
	}
	
	public function _setPictureData($data)
	{
		$this->_data = $data;
		switch ($data['directory'])
		{
		case 'pss':
		  $this->_filepath = APPLICATION_PATH . '/../public/images/pss/';
		  break;
		default:
		  throw new Zend_Exception("Please specify a path when instantiating a Filemanage object");
		}

	}
	
	public function _didFileUploadOk()
	{
		if($this->_restrictionsCheckOut())
		{
			if($this->_madeDir())
			{
			}
			else
			{
				return false;
			}
			
		}
		else
		{
			return false;
		}
			
	}
	
	public function _restrictionsCheckOut()
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$explode = explode(".", $this->_file["file"]["name"]);
		$extension = end($explode);
		
		if ((($this->_file["file"]["type"] == "image/gif")
		|| ($this->_file["file"]["type"] == "image/jpeg")
		|| ($this->_file["file"]["type"] == "image/jpg")
		|| ($this->_file["file"]["type"] == "image/pjpeg")
		|| ($this->_file["file"]["type"] == "image/x-png")
		|| ($this->_file["file"]["type"] == "image/png")
		|| ($this->_file["file"]["type"] == "application/octet-stream"))
		&& ($this->_file["file"]["size"] < $this->_data['max_file_size'])
		&& in_array($extension, $allowedExts))
		  {
		  if ($this->_file["file"]["error"] > 0)
			{
			return false;
			}
		  else
			{
			return true;			}
		  }
		else
		  {
		  return false;
		  }
	}
	
	public function _saveImage()
	{
		$name = $this->_file["file"]["name"];
		$explode = explode(".", $name);
		$extension = end($explode);
		return move_uploaded_file($this->_file["file"]["tmp_name"], $this->_filepath . $this->_data['picture_number'] . '.' . $extension);
	}

	public function _setPictureNumber($number)
	{
		$this->_data['picture_number'] = $number;
	}

	public function _getFileExtension()
	{
		$explode = explode(".", $this->_file["file"]["name"]);
		$extension = end($explode);
		return $extension;
	}
	

}
?>