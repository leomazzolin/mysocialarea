<?php
class Object_Dbtable
{
	private $_table;
	private $_datatable;
	private $_db;
	private $_id = NULL;
	private $_errors = array();

	function __construct($table = NULL, $search = NULL){
   		$config = Zend_Registry::get('appOptions');
		$this->_db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
		if($table != NULL){
			$this->_setTables($table);
			if($search != NULL){
				$this->_setID($search);
			}
		}
	}
	
	public function _setTables($table){
		$this->_table = new Zend_db_Table($table);
		$this->_datatable = new Zend_db_Table($table . '_data');
	}
	
	public function _setID($search){
		$payload = array();
		$where = array();
		foreach($search as $key => $value){
			$where[$key . ' = ?'] = $value;
		}
		$this->_db->beginTransaction();
		try {
			$select = $this->_table->select();
			foreach($search as $key => $value){	
				$select->where($key . ' = ?', $value);
			}
			$select->order(array('created ASC'));
			$result = $this->_table->fetchRow($select)->toArray();
			$this->_db->commit();
		} catch (Exception $e) {
			$this->_db->rollBack();
			$this->_setError($e);
		}
		if($this->_getErrors() == NULL){
			$this->_id = $result['id'];
			return $this->_getId();			
		}
		else{
			return $this->_getErrors();
		}
		
	}
	
	public function _getId(){
		return $this->_id;
	}
	
	protected function _setError($e){
		$this->_errors[] = array(
								'message' => $e->getMessage(),
								'exception' => $e->getTraceAsString(),
								'request' => 'NONE'
								);		
	}

	protected function _getErrors(){
		return $this->_errors;
	}

	public function _get($search = NULL, $clean = true){
		$payload = array();
		$this->_db->beginTransaction();
		try {
			if($search == NULL){
				$select = $this->_table->select();
				$select->where('id = ?', $this->_id);
				$payload['general'] = $this->_table->fetchRow($select)->toArray();
				$select = $this->_datatable->select();
				$select->where('ref_id = ?', $this->_id)
						->order(array('created ASC'));
				$payload['data'] = $this->_datatable->fetchAll($select)->toArray();
			}
			else{
				if(array_key_exists('general', $search)){
					$select = $this->_table->select();
					if($search['general'] != NULL){
						$select->from($this->_table, $search['general']);
					}
					else{
					}
					$select->where('id = ?', $this->_id);
					$payload['general'] = $this->_table->fetchRow($select)->toArray();
				}
				if(array_key_exists('data', $search)){
					$select = $this->_datatable->select();
					$info = array();
					if($search['data'] != NULL){
						foreach($search['data'] as $key => $value){
							$info[$key] = $value;
								if(array_key_exists('description', $info)){
									foreach($info['description'] as $description){
										$select->orWhere('ref_id = "' .  $this->_id . '" AND category = "' . $info['category'] . '" AND description = "' . $description . '"');
									}
								}
								else{
									$select->where('ref_id = ?', $this->_id);
									$select->where('category = ?', $info['category']);
								}
						}
					}
					else{
						$select->where('ref_id = ?', $this->_id);
					}
					$payload['data'] = $this->_datatable->fetchAll($select)->toArray();
				}
			}
			$this->_db->commit();
		} catch (Exception $e) {
			$this->_db->rollBack();
			$this->_setError($e);
		}
		if($this->_getErrors() == NULL){
			return $payload;
		}
		else{
			return $this->_getErrors();
		}
	}
	
}

?>