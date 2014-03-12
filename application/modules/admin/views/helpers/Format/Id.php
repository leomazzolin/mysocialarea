<?php
class Zend_View_Helper_Format_Id extends Zend_View_Helper_Abstract
{
    public function Format_Id ( $id )
    {
		$return = strtolower(base_convert($id, 10, 36));
		$return = str_pad( $return, 6, "0", STR_PAD_LEFT);
		return $return;
    }
}
?>