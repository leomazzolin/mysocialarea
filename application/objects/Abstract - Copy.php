<?php
class Object_Abstract
{
    /**
     * The default table name
     */
    protected $_name = NULL;
	
	protected $_db = NULL;
	
	protected $_data = array(
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
						
	protected $_data_descriptors = array( 'id', 'tbl', 'ref_id', 'category', 'description', 'value', 'created', 'modified' );
	
	function __construct( $name = NULL ){
		if($name != NULL){
			return $this->_setTable($name);
		}
		else{
			return $this->_name;
		}
	}

	/*
	 * PROTECTED FUNCTIONS
	 */	
	protected function _ensureSingleItem($id){
		return count($this->_read(array('id' => $id)));		
	}
	
	protected function _getSingleDataItem($data){
		$search = array();
		foreach($data as $key => $value){
			if($key != 'value'){
				$search[$key] = $value;
			}
		}
		return $this->_readData($search);
	}

	protected function _error($e){
		return array( 'errors' => array(
				'message' => $e->getMessage(),
				'exception' => $e->getTraceAsString(),
				'request' => 'NONE'
				)
			);		
	}

	protected function _boolDataKeysOk($data){
		$bool = array(true);
		
		foreach($data as $key => $value){
			if(in_array($key, $this->_data_descriptors)){
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
	 * FUNCTIONS FOR INSTANTIATING OBJECTS
	 */
	public function _setObject( $name = NULL ){
   		$config = Zend_Registry::get('appOptions');
		$this->_db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		$this->_name = $name;
		return array(
						'name' => $this->_name,
						'db' => $this->_db
					);
	}

	public function _populate($search){
		$this->_user = array();
		$this->_user['general'] = $this->_toRow(
										$this->_read($search)
											);
		$categories = array( 'personal', 'facebook', 'twitter' );
		foreach($categories as $c){
			$search = array(
						'ref_id' => $this->_user['general']['id'],
						'category' => $c,
						);
			$this->_user[$c] = $this->_unpackData($this->_readData($search));
		}
		return $this->_user;
		
	}

	/*
	 * UTILITY FUNCTIONS
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	public function _toRow($rowset){
		$payload = array();
		if(count($rowset) == 1){
			foreach($rowset[0] as $key =>$value){
				$payload[$key] = $value;
			}
		}
		return $payload;
	}
	
	public function _unpackData($rowset){
		$payload = array();
		try{
			foreach($rowset as $row){
				$payload[trim($row['description'])] = trim($row['value']);
			}
			return $payload;
		}catch (Exception $e){
			return $this->_error($e);
		}
	}
	
	
	/*
	 *  PUBLIC FUNCTIONS FOR BASIC USE
	 */
	public function _byId($data){
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	public function _read($item){
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	public function _insert($item){
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	public function _update($data){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			$entry = array();
			foreach($data as $key => $value){
				if($key != 'id' && $key != 'created' && $key != 'modified'){
					$entry[$key] = $value;
				}
			}
			$payload = $this->_db->update($this->_name, $entry, 'id = ' . $data['id']);
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	public function _delete($data){
		$payload = array();
		try{
			$item_to_delete = $this->_read($data);
			if(count($item_to_delete) != 1){
				throw new Exception("Table->_delete() 1<br />Invalid number of items returned...can only be 1 ");
			}
		} catch (Exception $e) {
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	public function _byIdData($data){
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	public function _readData($data){
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
				$stmt = $this->_db->query($select);
				$result = $stmt->fetchAll();
				$this->_db->commit();
				$payload = $result;
				return $payload;
			}else{
				throw new Exception("Table->_readData 1<br />Inproper data keys supplied.");
			}
		} catch (Exception $e) {
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}
	
	public function _editData($data){
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

	public function _deleteData($data){
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
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
			// If any of the queries failed and threw an exception,
			// we want to roll back the whole transaction, reversing
			// changes made in the transaction, even those that succeeded.
			// Thus all changes are committed together, or none are.
			$this->_db->rollBack();
			return $this->_error($e);
		}
	}

}

?>