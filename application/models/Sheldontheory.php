<?php
class Model_Sheldontheory extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name = 'sheldontheory';
	
	protected $_orderBy = array( 
									'chr-desc' => array(
														'season DESC',
                           								'episode DESC',
														'created DESC',
													),
									'chr-asc' => array(
														'season ASC',
                           								'episode ASC',
														'created ASC',
													),
									'views-desc' => array(
														'views DESC',
														'created DESC',
													),
								);
	
	protected $_order = 'chr-desc';
	
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