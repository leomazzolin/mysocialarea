<?php
class Model_Users extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name = 'users';
	
	
/*
**NEW AND IMPROVED METHODS WHEN I FINALLY ACHEIVED ENLIGHTENMENT
**THESE WERE FORMED WHEN I CREATED USER MODULE IN ADMIN 
*/

	public function _get($data = NULL)
	{
		if(is_numeric($data))
		{
			$row = $this->find($data)->current();
			if($row)
			{
				return $row;
			}
			else
			{
				throw new Zend_Exception("Could not get user: exception 1");
			}
		}
		elseif(is_null($data))
		{
			$select = $this->select();
			$result = $this->fetchAll($select);
			if ($result) {
				return $result;
			} else {
				throw new Zend_Exception("Could not get user: exception 2");
			}
		}
		elseif(is_array($data))
		{
			switch (key($data))
			{
			case 'user_data':
				$array = $data['user_data'];
				$table = new Model_Userdata();    
				$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select->where('user_id = ?', $array['id']);    
				$select->where('description LIKE ?', $array['desc'] . '.%');
				$rows = $table->fetchAll($select);
				if($rows)
				{
					for($i=0; $i <  $rows->count(); $i++)
					{
						$rows->seek($i); 
						$rows->current()->description = ucfirst(
														str_replace('_', ' ', 
														str_replace($array['desc'] . '.', '', $rows->current()->description
														)));
					}
					return $rows;
				}
				else
				{
					throw new Zend_Exception("Could not get personal data.");
				}
				break;
			case 'col':
				$array = $data['col'];
				$select = $this->select();
				$select->where(key($array) . ' = ?', $array[key($array)]);    
				$result = $this->fetchRow($select);
				if ($result) {
					return $result;
				} else {
					throw new Zend_Exception("Could not get user: exception 2");
				}
				break;
			default:
				return NULL;
				break;
			}
			$select = $this->select();
			$result = $this->fetchAll($select);
			if ($result) {
				return $result;
			} else {
				throw new Zend_Exception("Could not get user: exception 2");
			}
		}
		else
		{
			throw new Zend_Exception("Could not get user: reached else condition");
		}
	}

/////////////	
	public function authenticate($data)
	{
		//set up the auth adapter
		// get the default db adapter
		$db = Zend_Db_Table::getDefaultAdapter();
		//create the auth adapter
		$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users',
			'email', 'password');
		//set the username and password
		if($data->email == NULL){
			$data->email = 'not_given';
		}
		$authAdapter->setIdentity($data->email);
		$authAdapter->setCredential(md5($data->password));
		//authenticate
		$result = $authAdapter->authenticate();
		if ($result->isValid()) {
			// store the username, first and last names of the user
			$auth = Zend_Auth::getInstance();
			$storage = $auth->getStorage();
			$storage->write($authAdapter->getResultRowObject(array('id', 'email')));
			//$ident = $auth->getIdentity();
			return true;
		}
		else{
			return false;
		}
	}

	public function create($data)
	{
		// create a new row
		$row = $this->createRow();
		if ($row) {
			// update the row values
			$row->email = $data->email;
			$row->name = $data->name;
			$row->username = $data->username;
			$row->birthday = $data->birthday;
			$row->password = md5($data->password);
			$row->token = $data->token;
			$row->token_reason = $data->token_reason;
			$row->last_updated = $data->last_updated;
			$row->save();
			//return the new user
			return $row;
		} else {
			return false;
			throw new Zend_Exception("Could not create user! ");
		}
	}

	public function activate_user($data)
	{
		$mdl_UD = new Model_Userdata();    
		// fetch the user's row
		$row = $this->find($data->id)->current();
	
		if($row)
		{
			// update the row values
			$row->token = NULL;
			$row->token_reason = NULL;
			$row->password = md5($data->password);
			$row->save();
			$mdl_UD->activate_user($data);
		}
		else
		{
			throw new Zend_Exception("User update failed.  User not found!");
		}
	}

	public function set_email($data)
	{
		$mdl_UD = new Model_Userdata();    
		// fetch the user's row
		$row = $this->find($data->id)->current();
	
		if($row)
		{
			// update the row values
			$row->email = $data->email;
			$row->token = $data->token;
			$row->token_reason = $data->token_reason;
			$row->save();
		}
		else
		{
			throw new Zend_Exception("Email update failed!");
		}
	}

	public function verify_email_token($data)
	{
		$self = new self;
		$row = $self->get_by_email($data->email);
		
		if($row && $row->token == $data->token && $row->token_reason == 'email')
		{
			// update the row values
			$row->email = $data->email;
			$row->token = NULL;
			$row->token_reason = NULL;
			$row->save();
			return true;
		}
		else
		{
			return false;
		}
	}

	public function verify_password_token($data)
	{
		$self = new self;
		$row = $self->get_by_email($data->email);
		
		if($row && $row->token == $data->token && $row->token_reason == 'password')
		{
			// update the row values
			$row->password = md5($data->password);
			$row->token = NULL;
			$row->token_reason = NULL;
			$row->save();
			return true;
		}
		else
		{
			return false;
		}
	}

	public function set_token($data)
	{
		$self = new self;
		$row = $self->get_by_email($data->email);
		
		if($row)
		{
			$row->token = $data->token;
			$row->token_reason = $data->token_reason;
			$row->save();
			return true;
		}
		else
		{
			return NULL;
		}
	}

	public function check_token($data)
	{
		$self = new self;
		$row = $self->get_by_email($data->email);
		
		if($row)
		{
			switch ($row->token_reason)
			{
			case 'new_user':
				return 'activate';
				break;
			case 'email':
				return 'email';
				break;
			case 'password':
				return 'password';
				break;
			case NULL:
				return 'ok';
				break;
			default:
				return NULL;
				break;
			}
		}
		else
		{
			return NULL;
		}
	}

	public function check_password($data)
	{
		$self = new self;
		$row = $self->get_single($data->id);
		
		if($row && $row->pwd == md5($data->password))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function set_new_password($data)
	{
		$row = $this->find($data->id)->current();
		if($row)
		{
			if ($row->password == md5($data->old_password))
			{
				$row->password = md5($data->password);
				$row->save();
				return 'success';
			}
			else
			{
				return 'incorrect_password';
			}
		}
		else
		{
			return false;
		}
	}

	public function set_personal_data($data)
	{
		$row = $this->find($data->id)->current();
		if($row)
		{
			if ($row->password == md5($data->old_password))
			{
				$row->password = md5($data->password);
				$row->save();
				return 'success';
			}
			else
			{
				return 'incorrect_password';
			}
		}
		else
		{
			return false;
		}
	}

	public function get_by_email($email)
	{
        $select = $this->select();
		$select->where('email = ?', $email);
        $result = $this->fetchRow($select);
        if ($result) {
            return $result;
        } else {
            return NULL;
        }
	}
	
	public function get_all_users()
	{
        $select = $this->select();
        $result = $this->fetchAll($select);
        if ($result) {
            return $result;
        } else {
            return NULL;
        }
	}

	public function get_single($id)
	{
        $select = $this->select();
		$select->where('id = ?', $id);
        $result = $this->fetchRow($select);
        if ($result) {
            return $result;
        } else {
            return NULL;
        }
	}

	public function get_all_info($id)
	{
        $select = $this->select();
		$select->where('id = ?', $id);
        $result = $this->fetchRow($select);
        if ($result)
		{
			$mdl_UD = new Model_Userdata();
			$rows = $mdl_UD->get_single($id);
			$user_data = new stdClass;
			foreach($rows as $row)
			{
				switch ($row->description)
				{
				case 'username':
					$user_data->username = $row->value;
					break;
				case 'first_name':
					$user_data->first_name = $row->value;
					break;
				case 'last_name':
					$user_data->last_name = $row->value;
					break;
				default:
					break;
				}
			}
			$return = new stdClass;
			$return->user = $result;
			$return->user_data = $user_data;
            return $return;
        }
		else
		{
            return NULL;
        }
	}

	public function get_week_answers($data)
	{
		$self = new self;
		$mdl_UA = new Model_Useranswers();
		$mdl_U = new Model_My_Utility();
		$container_users = array();
		$all_users = $self->get_all_users();
		foreach($all_users as $row)
		{
			$user = new stdClass;
			$user->id = $row->id;
			$container_answers = array();
			foreach($data as $d)
			{
				$line = new stdClass;
				$input = new stdClass;
				$line->question_id = $d->question_id;
				$input->question_id = $d->question_id;
				$input->user_id = $row->id;
				$line->answer = $mdl_UA->get_answer($input);
				$container_answers[$d->question_id] = $line;
			}
			$user->answers = $container_answers;
			$container_users[] = $user;
		}
		return $container_users;
	}

}

?>