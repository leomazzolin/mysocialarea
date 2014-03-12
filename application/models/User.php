<?php
class Model_User extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name = 'user';
	
	
	protected $_orderBy = array( 
									'email-desc' => array(
														'email DESC',
														'created DESC',
													),
									'email-asc' => array(
														'email ASC',
														'created ASC',
													),
								);
	
	protected $_order = 'email-desc';
	
	public function getAll()
	{
        $select = $this->select();
		$select->order($this->_orderBy[$this->_order]);
        $result = $this->fetchAll($select)->toArray();
        if (count($result) > 0) {
            return $result;
        } else {
            return NULL;
        }
	}
	
	public function _setOrder($order)
	{
		if(array_key_exists($order, $this->_orderBy)){
			$this->_order = $order;
		}
	}

}

?>