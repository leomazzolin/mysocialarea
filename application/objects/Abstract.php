<?php
abstract class Object_Abstract
{
    /**
     * PRIVATE DATA
     */
    private $_name = NULL;
	
	private $_db = NULL;
	
	private $_data = array(
			/*TABLE*/	'users' => array(
			/*CATEGORIES*/	'personal' => array('name', 'username', 'password', 'birthday' ),
							'facebook' => array('oauth_token', 'fb_id'),
							'twitter' => array('access_token', 'token_secret'),
							'token' => array('reason', 'token'),
							),
			/*TABLE*/	'test' => array(
			/*CATEGORIES*/	'cat1' => array('desc1', 'desc2' ),
							'cat2' => array('desc1', 'desc2' ),
							),
						);
						
	private $_CategoryValues = array( 'id', 'tbl', 'ref_id', 'category', 'description', 'value', 'created', 'modified' );
	
	/*
	 * PROTECTED DATA
	 */
	protected $_object = NULL;

	function __construct(){
		
	}
	
	abstract public function _sanitize();

	/*
	* PRIVATE FUNCTIONS
	*/
	private function _byId($data){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$select = $this->_db->select()
						->from($this->_name);
						$i = 0;
			foreach($data as $d){
				if($i == 0){
					$select->where( 'id = ?', $d);
				}else{
					$select->orWhere( 'id = ?', $d );
				}
				$i++;
			}
			$stmt = $this->_db->query($select);
			$payload = $stmt->fetchAll();
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	private function _read($item){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$select = $this->_db->select()
						->from($this->_name);
			foreach($item as $key => $value){
				$select->where( $key . ' = ?', $value );
			}
			$stmt = $this->_db->query($select);
			$payload = $stmt->fetchAll();
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _insert($item){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$created = new Zend_Db_Expr('NOW()');
			$item['created'] = $created;
			$this->_db->insert($this->_name, $item);
			$itemID = $this->_db->lastInsertId();
			$this->_db->commit();
			return $itemID;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	private function _update($data){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$payload = $this->_db->update($this->_name, $data, 'id = ' . $this->_object['general']['id']);
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _delete($data){
		$payload = array();
		try{
			$item_to_delete = $this->_read($data);
			if(count($item_to_delete) != 1){
				throw new Exception("Table->_delete() 1<br />Invalid number of items returned...can only be 1 ");
			}
		} catch (Exception $e) {
			return $this->_error($e);
		}
	
		try{
			if(array_key_exists('id', $item_to_delete[0])){
				$search = array(
					'tbl' => $this->_name,
					'ref_id' => $item_to_delete[0]['id'],
				);
				$data_items_to_delete = $this->_readData($search);
				foreach($data_items_to_delete as $delete){
					$this->_deleteData($delete);
				}
			}else{
				throw new Exception("Table->_delete() 2<br />id array key does not exist");
			}
		} catch (Exception $e) {
			return $this->_error($e);
		}

		$this->_db->beginTransaction();
		try {
			if(array_key_exists('id', $item_to_delete[0])){
				$payload = $this->_db->delete($this->_name, 'id = ' . $item_to_delete[0]['id']);
			}else{
				throw new Exception("Invalid id...Value given: " . $item_to_delete[0]['id']);
			}
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _byIdData($data){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$select = $this->_db->select()
						->from('data');
			$i = 0;
			foreach($data as $d){
				if($i == 0){
					$select->where( 'id = ?', $d);
				}else{
					$select->orWhere( 'id = ?', $d );
				}
				$i++;
			}
			$stmt = $this->_db->query($select);
			$payload = $stmt->fetchAll();
			$this->_db->commit();
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
						->from('data');
			$select->where('tbl = ?', $this->_name);
			if($this->_boolDataKeysOk($data)){
				foreach($data as $key => $value){
					$select->where( $key .' = ?', $value);
				}
				$select->order(array('category ASC', 'description ASC'));
				$stmt = $this->_db->query($select);
				$result = $stmt->fetchAll();
				$this->_db->commit();
				$payload = $result;
				return $payload;
			}else{
				throw new Exception("Table->_readData 1<br />Inproper data keys supplied.");
			}
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	private function _editData($data){
		$payload = array();
		try{
			$single_item = $this->_ensureSingleItem($data['ref_id']);
			if($this->_ensureSingleItem($data['ref_id']) != 1){
				throw new Exception("Table->_editData 1<br />Invalid number of items returned...can only be 1 ");
			}
			$read = $this->_getSingleDataItem($data);
			if ($read != false && count($read) != 1){
				throw new Exception("Table->_editData 2<br />Invalid number of data items returned...can only be 1 ");
			}
		} catch (Exception $e) {
			return $this->_error($e);
		}
		
		$this->_db->beginTransaction();
		try {
			if( $read == false){
				$created = new Zend_Db_Expr('NOW()');
				$item['created'] = $created;
				$item['tbl'] = $this->_name;
				$item['ref_id'] = $data['ref_id'];
				$item['category'] = $data['category'];
				$item['description'] = $data['description'];
				$item['value'] = $data['value'];
				$this->_db->insert('data', $item);
				$payload = $this->_db->lastInsertId();
			}elseif(count($read) == 1){
				$payload = $this->_db->update('data', array('value' => $data['value']), 'id = ' . $read[0]['id']);
			}else{
				throw new Exception("Table->_editData 3<br />Invalid number of data items returned...can only be false or 1 ");
			}
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	private function _deleteData($data){
		$payload = array();
		try{
			$single_item = $this->_ensureSingleItem($data['ref_id']);
			if($this->_ensureSingleItem($data['ref_id']) != 1){
				throw new Exception("Invalid number of items returned...can only be 1 ");
			}
			$read = $this->_getSingleDataItem($data);
			if (count($read) != 1){
				throw new Exception("Invalid number of data items returned...can only be 1 ");
			}
		} catch (Exception $e) {
			return $this->_error($e);
		}

		$this->_db->beginTransaction();
		try {
			if(!is_numeric($read[0]['id']) && $read[0]['id'] < 1){
				throw new Exception("Invalid id...Value given:" . $read[0]['id']);
			}else{
				$payload = $this->_db->delete('data', 'id = ' . $read[0]['id']);
			}
			$this->_db->commit();
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

	protected function _setObject( $name ){
   		$config = Zend_Registry::get('appOptions');
		$this->_db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		$this->_name = $name;
		return array(
						'name' => $this->_name,
						'db' => $this->_db
					);
	}

	protected function _populate($search){
		$payload = array();
		$rowset = $this->_read($search);
		switch(count($rowset)){
			case 1:
				$payload['general'] = $this->_toRow($rowset);
				$search = array(
							'ref_id' => $payload['general']['id'],
							);
				$payload['data'] = $this->_readData($search);
				return $payload;
			case 0:
				return NULL;
				break;
			default:
				return NULL;
				break;
		}
		
	}

	protected function _boolDataKeysOk($data){
		$bool = array(true);
		
		foreach($data as $key => $value){
			if(in_array($key, $this->_CategoryValues)){
				$bool[] = true;
			}
			else{
				$bool[] = false;
			}
		}
	
		if(array_key_exists('ref_id', $data)){
			$bool[] = true;
		}
		else{
			$bool[] = false;
		}
		
		if(array_key_exists('description', $data)){
			if(array_key_exists('category', $data)){
				$bool[] = true;
			}
			else{
				$bool[] = false;
			}
		}
		
		if(array_key_exists('value', $data)){
			if(array_key_exists('description', $data)){
				if(array_key_exists('category', $data)){
					$bool[] = true;
				}
				else{
					$bool[] = false;
				}
				$bool[] = true;
			}
			else{
				$bool[] = false;
			}
		}
		
		$i = 0;
		foreach($bool as $b){
			if($b == false){
				$i++;
			}
		}
		if($i == 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	/*
	 * PUBLIC FUNCTIONS
	 */
	public function _overview(){
		$payload = array();
		$this->_db->beginTransaction();
		try{
			$select = $this->_db->select()
						->from(array('item' => $this->_name), array('COUNT(item.id) AS count', 'MAX(item.created) AS latest'));
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
	
	public function _getObject(){
		$payload = array();
		$categories = array();
		if($this->_object == NULL){
			return $payload;
		}else{
			$payload['general'] = $this->_object['general'];
			foreach($this->_object['data'] as $row){
				if(!in_array($row['category'], $categories)){
						$categories[] = $row['category'];
				}
			}
			foreach($categories as $category){
				$payload['data'][$category] = $this->_getCategory($category);
			}
			return $payload;
		}
	}

	public function _newObject($insert){
		$id = $this->_insert($insert);
		if(is_numeric($id) && $id > 0){
			$search = array( 'id' => $id );
			$this->_object = $this->_populate($search);
			return $id;
		}
		else{
			return NULL;
		}
	}

	public function _updateGeneralData($edit){
		$result = $this->_update($edit);
		if( $result == 1){
			foreach($edit as $key => $value){
				$this->_object['general'][$key] = $value;
			}
			return $result;
		}
		else{
			return NULL;
		}
	}
	
	public function _deleteObject(){
		$
		$result = $this->_delete($delete);
		if( $result == 1){
			foreach($edit as $key => $value){
				$this->_object['general'][$key] = $value;
			}
			return $result;
		}
		else{
			return NULL;
		}
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

}

?>