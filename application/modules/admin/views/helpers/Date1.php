<?php
class Zend_View_Helper_Date1 extends Zend_View_Helper_Abstract
{
    public function Date1 ( $date )
    {
		if (preg_match("/\d\d\d\d-\d\d-\d\d/", $date))
		{ 
			$formatted = new Zend_Date();
			$d = explode("-", $date);
			$formatted->set($d[2] . '.' . $d[1] . '.' . $d[0], Zend_Date::DATE_FULL);
			return $formatted->get(Zend_Date::DATE_FULL);
		}
		else
		{
			return NULL;
        }

    }
}
?>