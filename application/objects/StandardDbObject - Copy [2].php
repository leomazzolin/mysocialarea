<?php
class Object_StandardDbObject
{
	/*
	* VARIABLES
	*/
	private $_db = NULL;

	private $_obj = NULL;
	private $_dataTablePostfix = '_data';
	private $_objData = NULL;

	private $_objPayload = array(
									'id' => NULL,
									'general' => NULL,
									'data' => NULL
								);

	private $_search = array();
	
	private $_errors = array();
	private $_reflectionClass = NULL;
	private $_exceptionHeader = 'FORCED StandardDbObject EXCEPTION THROWN...<br />';
	private $_errorHandler = NULL;
	
	/*
	* CONSTRUCTOR
	*/
	function __construct($table){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$this->_reflectionClass = new Zend_Reflection_Class($this);
		try{
			$config = Zend_Registry::get('appOptions');
			$this->_db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);
			$this->_errorHandler = new Class_Errorhandler();
			$this->_setObject($table);
		} catch (Exception $e) {
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
	}
	
	/*
	* PRIVATE METHODS TO INIT OBJECT
	*/
	private function _setObject($table){
		$this->_obj = $table;
		$this->_objData = $this->_obj . $this->_dataTablePostfix;
	}
	
	public function _setSearch($search){
		$this->_search = $search;
	}
	
	public function _setFilter($filter){
		$this->_filter = array_merge($this->_filter, $filter);
	}
	
	private function _queryObjGeneral(){
		$this->_db->beginTransaction();
		try{
			$select = $this->_db->select();
			$select->from($this->_obj);
			if(is_numeric($this->_getObjId()) && $this->_getObjId() > 0){
				$select->where('id = ?', $this->_getObjId());
			}
			else{
				foreach($this->_search as $key => $value){
					$select->where($key . ' = ?', $value);
				}		
			}
			$stmt = $this->_db->query($select);
			$result = $stmt->fetchAll();
			$this->_db->commit();
		}
		catch (Exception $e){
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
			$result = -1;
		}
		return $result;
	}

	private function _queryObjData(){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$this->_db->beginTransaction();
		try{
			$select = $this->_db->select();
			$select->from($this->_objData);
			$select->where('ref_id = ?', $this->_getObjId());
			$select->order(array('category ASC', 'description ASC'));
			$stmt = $this->_db->query($select);
			$result = $stmt->fetchAll();
			$this->_db->commit();
		}
		catch (Exception $e){
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
			$result = -1;
		}
		return $result;
	}

	private function _setObjGeneral(){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$payload = array();
		try {
			$general = $this->_queryObjGeneral();
			$count = count($this->_queryObjGeneral());
			switch($count){
				case 1:
					$this->_setObjId($general[0]['id']);
					unset($general[0]['id']);
					$this->_objPayload['general'] = $general[0];
					$this->_setObjData();
					break;
				case 0:
					$this->_setObjId(NULL);
					$this->_objPayload['general'] = NULL;
					$this->_objPayload['data'] = NULL;
					break;
				default:
					$this->_setObjId(NULL);
					$this->_objPayload['general'] = NULL;
					$this->_objPayload['data'] = NULL;
					throw new Exception($this->_exceptionHeader . "Improper result count returned so general data could not be set. 0 or 1 allowed...$count returned.");
					break;		
			}
		} catch (Exception $e) {
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		
	}
	
	private function _setObjData(){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		try {
			$this->_objPayload['data'] =  $this->_queryObjData();
		} catch (Exception $e) {
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		
	}

	public function _setObjPayload($search = NULL){
		if($search != NULL){
			$this->_setSearch($search);
		}
		if($this->_search == NULL){
			return NULL;
		}
		else{
			$this->_setObjGeneral();
			//THIS GETS DONE IN _setObjGeneral() IF IT IS SUCCESSFUL
			//$this->_setObjData();
			if($this->_getObjId() == NULL){
				return NULL;
			}
			else{
				return $this->_objPayload;
			}
		}
	}
	
	public function _getId(){
		return $this->_getObjId();
	}

	public function _getGeneral(){
		return $this->_objPayload['general'];
	}
	
	public function _getData($getWhat = NULL){
		$data_count = count($this->_objPayload['data']);
		$row = reset($this->_objPayload['data']);
		$data = array();
		$i = 0;
		while($i != $data_count){
			switch($getWhat){
				case 'id':
					$data[] = $row['id'];
					break;
				case NULL:
				default:
					$data[] = $row;
					break;
			}
			$i++;
			$row = next($this->_objPayload['data']);
		}
		return $data;
	}
	
	public function _getDataItem($category, $description, $getWhat = NULL ){
		$data_count = count($this->_objPayload['data']);
		$row = reset($this->_objPayload['data']);
		$value = NULL;
		$i = 0;
		while($i != $data_count){
			if($row['category'] == $category && $row['description'] == $description){
				switch($getWhat){
					case 'id':
						$value = $row['id'];
						break;
					case 'row':
						$value = $row;
						break;
					case NULL:
					default:
						$value = $row['value'];
						break;
				}
				break;
			}
			else{
				$i++;
				$row = next($this->_objPayload['data']);
			}
		}
		return $value;
	}
	
	public function _getDataCategory($category, $getWhat = NULL ){
		$value = array();
		foreach($this->_objPayload['data'] as $row){
			if($row['category'] == $category){
				switch($getWhat){
					case 'id':
						$value[] = $row['id'];
						break;
					case 'row':
						$value[] = $row;
						break;
					case NULL:
					default:
						$value[$row['description']] = $row['value'];
						break;
				}
			}
		}
		return $value;
	}

	/*
	* METHODS FOR PUBLIC _GET() METHOD -- MAY CONTAIN PRIVATE AND PROTECTED METHODS
	*/	
	public function _new($data){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$id = 0;
		$this->_db->beginTransaction();
		try{
			$data['created'] = date("Y-m-d H:i:s", time());
			$this->_db->insert($this->_obj, $data);
			$id = $this->_db->lastInsertId();
			$this->_db->commit();
		}
		catch (Exception $e) {
			$id = 0;
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		if(is_numeric($id) && $id > 0){
			$this->_resetObj();
			$this->_setSearch(array('id' => $id));
			$this->_setObjPayload();
			return $id;
		}
		else{
			return NULL;
		}
	}

	public function _editGeneral($data){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$row = $this->_queryObjGeneral();
		try{
			switch(count($row)){
				case 1:
					$this->_db->beginTransaction();
					try{
						$where = array();
						$where['id = ?'] = $this->_getObjId();
						$this->_db->update($this->_obj, $data, $where);
						$this->_db->commit();
					}
					catch (Exception $e) {
						$this->_db->rollBack();
						$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
					}
					break;
				default:
					throw new Zend_Exception("Could not update general data.");
					break;
			}
		}
		catch (Exception $e) {
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		$this->_setObjPayload();
	}

	public function _updateData($updates){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$this->_db->beginTransaction();
		try{
			foreach($updates as $update){
				$where = array();
				$where['ref_id = ?'] = $this->_getObjId();
				$where['category = ?'] = $update['category'];
				$where['description = ?'] = $update['description'];
				$select = $this->_db->select()
							->from($this->_obj . '_data');
				foreach($where as $key =>$value){
					$select->where($key, $value);
				}
				$stmt = $this->_db->query($select);
				$result = $stmt->fetchAll();
				$count = count($result);
				switch($count){
					case 1:
						$where = array();
						$where['id = ?'] = $result[0]['id'];
						$this->_db->update($this->_objData, array('value' => $update['value']), $where);
						break;
					case 0:
						$update['ref_id'] = $this->_getObjId();
						$update['created'] = date("Y-m-d H:i:s", time());
						$this->_db->insert($this->_objData, $update);
						break;
					default:
						throw new Exception($this->_exceptionHeader . "Improper result count returned. 0 or 1 allowed...$count returned.");
						break;		
				}
			}
			$this->_db->commit();
		}
		catch (Exception $e) {
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		$this->_setObjPayload();
	}

	public function _updateDataById($updates){
		$resetObjayload = true;
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$this->_db->beginTransaction();
		try{
			foreach($updates as $update){
				$where = array();
				$where['id = ?'] = $update['id'];
				$select = $this->_db->select()
							->from($this->_objData);
				foreach($where as $key =>$value){
					$select->where($key, $value);
				}
				$stmt = $this->_db->query($select);
				$result = $stmt->fetchAll();
				$count = count($result);
				switch($count){
					case 1:
						$where = array();
						$where['id = ?'] = $update['id'];
						$this->_db->update($this->_objData, array('value' => $update['value']), $where);
						break;
					default:
						throw new Exception($this->_exceptionHeader . "Improper result count returned. Only 1 allowed for updating data by Id because must know ategory and description to insert...$count returned.");
						break;		
				}
			}
			$this->_db->commit();
		}
		catch (Exception $e) {
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		$this->_setObjPayload();
	}
	
	public function _delete(){	
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$delete_count = array( 'general' => 0, 'data' => 0);;
		if(is_numeric($this->_getObjId()) && $this->_getObjId() > 0){
			$this->_db->beginTransaction();
			try{
				$where = array();
				$where['ref_id = ?'] = $this->_getObjId();
				$delete_count['data'] += $this->_db->delete($this->_objData, $where);
				$where = array();
				$where['id = ?'] = $this->_getObjId();
				$delete_count['general'] += $this->_db->delete($this->_obj, $where);
				$this->_db->commit();
			}
			catch (Exception $e) {
				$this->_db->rollBack();
				$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
			}
			$this->_setObjPayload();
			return $delete_count;
		}
		else{
			return NULL;
		}
	}

	public function _deleteDataItem($deletes){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$delete_count = 0;
		$this->_db->beginTransaction();
		try{
			foreach($deletes as $delete){
				$select = $this->_db->select()->from($this->_objData);
				$where = array();
				$where ['ref_id = ?'] = $this->_getObjId(); 
				$where['category = ?'] = $delete['category'];
				$where['description = ?'] = $delete['description'];
				foreach($where as $key => $value){
					$select->where($key, $value);
				}
				$stmt = $this->_db->query($select);
				$result = $stmt->fetchAll();
				$count = count($result);
				switch($count){
					case 1:
						$where = array();
						$where['id = ?'] = $result[0]['id'];
						$delete_count += $this->_db->delete($this->_objData, $where);
						break;
					case 0:
						break;
					default:
						throw new Exception($this->_exceptionHeader . "Could not delete row.");
						break;		
				}
			}
			$this->_db->commit();
		}
		catch (Exception $e) {
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		$this->_setObjPayload();
		return $delete_count;		
	}

	public function _deleteDataItemById($deletes){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$delete_count = 0;
		$this->_db->beginTransaction();
		try{
			foreach($deletes as $delete){
				$select = $this->_db->select()->from($this->_objData);;
				$select->where('id = ?', $delete);
				$stmt = $this->_db->query($select);
				$result = $stmt->fetchAll();
				$count = count($result);
				switch($count){
					case 1:
						$where = array();
						$where['id = ?'] = $delete;
						$delete_count += $this->_db->delete($this->_objData, $where);
						break;
					case 0:
						break;
					default:
						throw new Exception($this->_exceptionHeader . "Improper result count returned. 0 or 1 allowed...$count returned.");
						break;		
				}
			}
			$this->_db->commit();
		}
		catch (Exception $e) {
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		$this->_setObjPayload();
		return $delete_count;
	}

	public function _deleteDataCategory($deletes){
		$rMethod = new Zend_Reflection_Method(__METHOD__);
		$this->_db->beginTransaction();
		try{
			foreach($deletes as $delete){
				$select = $this->_db->select();
				$where = array();
				$where ['ref_id = ?'] = $this->_getObjId(); 
				$where['category = ?'] = $delete;
				$select->where($where);
				$result = $this->_db->delete($this->_objData, $where);
			}
			$this->_db->commit();
		}
		catch (Exception $e) {
			$this->_db->rollBack();
			$this->_errorHandler->_setError($this->_reflectionClass, $rMethod, $e);
		}
		$this->_setObjPayload();
		return $result;
	}

	/*
	* PUBLIC GETTERS AND SETTERS
	*/ 

	/*
	public function _getObjPayload(){
		return $this->_objPayload;
	}
	*/
	
	public function _getSearch(){
		return $this->_search;
	}

	public function _getFilter(){
		return $this->_filter;
	}

	public function _getObjId(){
		return $this->_objPayload['id'];
	}
	
	private function _setObjId($id){
		$this->_objPayload['id'] = $id;
	}

	public function _refresh(){
		return $this->_setObjPayload();
	}

	private function _resetObj(){
		$this->_objPayload = array(
								'id' => NULL,
								'general' => NULL,
								'data' => NULL
								);
		$this->_search = array();
	}

	public function _popGeneral($key){
		if(array_key_exists($key, $this->_objPayload['general'])){
			unset($this->_objPayload['general'][$key]);
		}
	}

}

?>