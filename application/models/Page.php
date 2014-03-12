<?php
class Model_Page extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name = 'page';
	
	public function getAll()
	{
        $select = $this->select();
        $result = $this->fetchAll($select)->toArray();
        if (count($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
	}

}

?>