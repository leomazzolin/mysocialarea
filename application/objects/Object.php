<?php
abstract class Object_Object
{
    /**
     * PRIVATE DATA
     */
    private $_TblName = NULL;
	private $_errors = array();
	private $_DataTblName = '_data';
	private $_db = NULL;		
	private $_CategoryValues = array( 'id', 'tbl', 'ref_id', 'category', 'description', 'value', 'created', 'modified' );
	
	/*
	 * PROTECTED DATA
	 */
	protected $_object = array(
								'general' => array(),
								'data' => array()
								);

	function __construct($obj = NULL, $search = NULL){
   		$config = Zend_Registry::get('appOptions');
		$this->_db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		if($obj != NULL){
			$this->_TblName = $obj;
			if($search != NULL){
				$this->_populate($search);
			}
		}
	}
	
	/*
	* ABSTRACT FUNCTIONS
	*/
	abstract public function _sanitize();

	/*
	* PRIVATE FUNCTIONS
	*/
	private function _read($read){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$select = $this->_db->select()
						->from($this->_TblName);
			foreach($read as $key => $value){
				$select->where( $key . ' = ?', $value );
			}
			$stmt = $this->_db->query($select);
			$payload = $stmt->fetchAll();
			switch(count($payload)){
				case 0:
					$payload = NULL;
					break;
				case 1:
					$this->_db->commit();
					break;
				default:
					throw new Exception("Object_Object->_read()<br />Invalid number of rows returned...can only be 1 ");
					break;
			}
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _insert($insert){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$created = new Zend_Db_Expr('NOW()');
			$insert['created'] = $created;
			$this->_db->insert($this->_TblName, $insert);
			$insertID = $this->_db->lastInsertId();
			$this->_db->commit();
			return $insertID;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	private function _update($update){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$this->_db->update($this->_TblName, $update, 'id = ' . $this->_object['general']['id']);
			$this->_db->commit();
			$payload = $this->_read(array('id' => $this->_object['general']['id']));
			$this->_object['general'] = $this->_toRow($payload);
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _delete(){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$payload = $this->_db->delete($this->_TblName, 'id = ' . $this->_object['general']['id']);
			$this->_db->commit();
			if(is_numeric(count($payload))){
				$this->_object['general'] = array();
			}
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _readData($data){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$select = $this->_db->select()
						->from($this->_TblName . $this->_DataTblName);
			$select->where('ref_id = ?', $this->_object['general']['id']);
			$select->order(array('category ASC', 'description ASC'));
			$stmt = $this->_db->query($select);
			$result = $stmt->fetchAll();
			$this->_db->commit();
			$payload = $result;
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _editData($edit){
		$payload = array();
		$editType = 'insert'; 
		$this->_db->beginTransaction();
		try {
			if(array_key_exists('data', $this->_object)){
				if(array_key_exists($edit['category'], $this->_object['data'])){
					if(array_key_exists($edit['description'], $this->_object['data'][$edit['category']])){
						$editType = 'update';
					}
				}
			}
			if($editType == 'insert'){
				$created = new Zend_Db_Expr('NOW()');
				$item['created'] = $created;
				$item['ref_id'] = $this->_object['general']['id'];
				$item['category'] = $edit['category'];
				$item['description'] = $edit['description'];
				$item['value'] = $edit['value'];
				$this->_db->insert($this->_TblName . $this->_DataTblName, $item);
				$insertID = 0;
				$insertID = $this->_db->lastInsertId();
				if($insertID > 0 && is_numeric($insertID)){
					$this->_object['data'][$edit['category']][$edit['description']] = $edit['value'];
				}
			}
			else{
				$where = array(
					'ref_id = ?' => $this->_object['general']['id'],
					'category = ?' => $edit['category'],
					'description = ?' => $edit['description'],
				);
				$result = $this->_db->update($this->_TblName . $this->_DataTblName, array('value' => $edit['value']), $where);
				if($result == 1){
					$this->_object['data'][$edit['category']][$edit['description']] = $edit['value'];
				}
			}
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	private function _deleteData(){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$payload = $this->_db->delete($this->_TblName . $this->_DataTblName, 'ref_id = ' . $this->_object['general']['id']);
			$this->_db->commit();
			if(is_numeric(count($payload))){
				$this->_object['data'] = array();
			}
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	private function _toRow($rowset){
		$payload = array();
		if(count($rowset) == 1){
			foreach($rowset[0] as $key =>$value){
				$payload[$key] = $value;
			}
		}
		return $payload;
	}

	protected function _error($e){
		return array( 'errors' => array(
				'message' => $e->getMessage(),
				'exception' => $e->getTraceAsString(),
				'request' => 'NONE'
				)
			);		
	}

	/*
	 * PROTECTED FUNCTIONS
	 */	
	protected function _setTblName($name){
		$this->_TblName = $name;
	}
	

	protected function _populate($search){
		$payload = array();
		$rowset = $this->_read($search);
		if($rowset != NULL){
			$this->_object['general'] = $this->_toRow($rowset);
			$search = array(
						'ref_id' => $this->_object['general']['id'],
						);
			$rowset = $this->_readData($search);
			$categories= array();
			$i = 0;
			foreach($rowset as $row){
				$this->_object['data'][$row['category']][$row['description']] = $row['value']; 
				$rowset[$i] = NULL;
				$i++;
			}
		}
	}
	
	/*
	 * PUBLIC FUNCTIONS
	 */
	public function _getObject(){
		return $this->_object;
	}

	public function _newObject($insert){
		$id = $this->_insert($insert);
		if(is_numeric($id) && $id > 0){
			$search = array( 'id' => $id );
			$this->_populate($search);
			return $id;
		}
		else{
			return NULL;
		}
	}

	public function _updateObject($edit){
		if(array_key_exists('general', $edit)){
		$result = $this->_update($edit['general']);
		}
		if(array_key_exists('data', $edit)){
			foreach($edit['data'] as $data){
				$this->_editData($data);
			}
		}

	}
	
	public function _deleteObject(){
		$this->_deleteData();
		$this->_delete();
		
	}

	public function _getGeneralData(){
		return $payload = $this->_object['general'];
	}

	public function _getDataValue($category, $description){
		$payload = NULL;
		if($this->_object == NULL){
			return $payload;
		}else{
			foreach($this->_object['data'] as $row){
				if($row['category'] == $category && $row['description'] == $description){
					$payload = trim($row['value']);
					break;
				}
			}
			return $payload;
		}
	}
	
	public function _getCategory($category){
		$payload = array();
		if($this->_object == NULL){
			return $payload;
		}
		else{
			foreach($this->_object['data'] as $row){
				if($row['category'] == $category){
						$payload[trim($row['description'])] = trim($row['value']);
				}
			}
			return $payload;
		}
	}

	public function _overview(){
		$payload = array();
		$this->_db->beginTransaction();
		try{
			$select = $this->_db->select()
						->from(array('item' => $this->_TblName), array('COUNT(item.id) AS count', 'MAX(item.created) AS latest'));
			$stmt = $this->_db->query($select);
			$overview = $stmt->fetch();
			$payload = $overview;
			$this->_db->commit();
			return $payload;
		}catch (Exception $e){
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	

}

?>