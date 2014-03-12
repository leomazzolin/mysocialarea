<?php
class Object_Dbtable
{
	/*
	* VARIABLES
	*/
	private $_table;
	private $_datatable;
	private $_db;
	private $_id = NULL;
	private $_errors = array();
	
	/*
	* CONSTRUCTOR
	*/
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
	
	/*
	* PUBLIC METHODS TO INIT OBJECT IF NOT INITED ON INSTANTIATION
	*/
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
	
	/*
	* PUBLIC METHODS
	*/ 
	public function _getId(){
		return $this->_id;
	}
	
	/*
	* GENERAL PRIVATE METHODS
	*/
	private function _setError($e){
		$this->_errors[] = array(
								'message' => $e->getMessage(),
								'exception' => $e->getTraceAsString(),
								'request' => 'NONE'
								);		
	}

	private function _getErrors(){
		return $this->_errors;
	}
	
	/*
	* METHODS FOR PUBLIC GET METHOD -- MAY CONTAIN PRIVATE AND PROTECTED METHODS
	*/
	private function _arrangeGet($payload, $search, $clean){
		$payloadData = array();
		if(array_key_exists('general', $search)){
			if(is_array($search['general'])){
				$generalPayload = array();
				$generalPayload['id'] = $payload['general']['id'];
				$generalPayload['created'] = $payload['general']['created'];
				$generalPayload['modified'] = $payload['general']['modified'];
				foreach($search['general'] as $column){
					if(array_key_exists($column, $payload['general'])){	
						$generalPayload[$column] = $payload['general'][$column];
					}
					else{
						$payload['general'][$column] = 'DNE!!!';
					}
				}
				$payload['general'] = $generalPayload;
			}
		}
		if($clean == true){
			array_pop($payload['general']);
			array_pop($payload['general']);
		}
		if(array_key_exists('data', $payload)){
			$count = count($payload['data']);
			for($i = 0; $i < $count; $i++){
				$payloadData[$payload['data'][$i]['category']][$payload['data'][$i]['description']]['id'] = $payload['data'][$i]['id'];
				//$payloadData[$payload['data'][$i]['category']][$payload['data'][$i]['description']]['ref_id'] = $payload['data'][$i]['ref_id'];
				$payloadData[$payload['data'][$i]['category']][$payload['data'][$i]['description']]['value'] = $payload['data'][$i]['value'];
				if($clean != true){
					$payloadData[$payload['data'][$i]['category']][$payload['data'][$i]['description']]['created'] = $payload['data'][$i]['modified'];
					$payloadData[$payload['data'][$i]['category']][$payload['data'][$i]['description']]['modified'] = $payload['data'][$i]['modified'];
				}
				$payload['data'][$i] = NULL;
			}
			$payload['data'] = $payloadData;
		}
		return $payload;
	}
	
	private function _filterGetData($search, $result){
		$payload = array();
		if($search == NULL){
			return $result;
		}
		else{
			if(array_key_exists('general', $result)){
				$payload['general'] = $result['general'];
			}
			/*
			if(array_key_exists('general', $search) && array_key_exists('general', $result)){
				if($search['general'] != '*'){
					if(is_array($search['general'])){
						foreach($search['general'] as $column){
							if(array_key_exists($column, $result['general'])){
								$payload['general'][$column] = $result['general'][$column];
							}
							else{
								$payload['general'][$column] = 'DNE!!!';
							}
						}
					}
				}
				else{
					$payload['general'] = $result['general'];
				}
			}
			*/
			if(array_key_exists('data', $search)){
				if($search['data'] == '*'){
					$payload['data'] = $result['data'];
				}
				if(is_array($search['data'])){
					foreach($search['data'] as $data){
						if(is_array($data)){
							if(array_key_exists('category', $data)){
								if(array_key_exists('description', $data)){
									if(is_array($data['description'])){
										$descriptions = $data['description'];
										foreach($result['data'] as $row){
											foreach($descriptions as $description){
												if($row['category'] == $data['category'] && $row['description'] == $description){
													$payload['data'][] = $row; 
												}
											}
										}
									}
									else{
										//THROW AN ERROR
									}
								}
								else{
									foreach($result['data'] as $row){
										if($row['category'] == $data['category']){
											$payload['data'][] = $row; 
										}
									}
								}
							}
						}
					}
				}
			}
			return $payload;
		}
	}

	public function _get($search = NULL, $clean = true){
		$payload = array();
		$result = array();
		$this->_db->beginTransaction();
		try {
			$select = $this->_table->select();
			$select->where('id = ?', $this->_id);
			$result['general'] = $this->_table->fetchRow($select)->toArray();
			$select = $this->_datatable->select();
			$select->where('ref_id = ?', $this->_id)
					->order(array('category ASC', 'description ASC'));
			$result['data'] = $this->_datatable->fetchAll($select)->toArray();
			$payload = $this->_filterGetData($search, $result);
			$payload = $this->_arrangeGet($payload, $search, $clean);
			$this->_db->commit();
			return $payload;
		} catch (Exception $e) {
			$this->_db->rollBack();
			$this->_setError($e);
			return $this->_getErrors();
		}
	}
	
}

?>