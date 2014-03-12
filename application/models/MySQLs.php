<?php
class Model_MySQLs
{
	
	public function getMarkableTests($course_id)
	{
		$date = Zend_Date::now();
		$date = $date->toString("YYYY-MM-dd HH:mm:ss");
		$table = new Model_Test();    
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->where('course_id = ?', $course_id)    
				->where('status = ?', 'Marked')
				->orWhere('status = ?', 'Ready')
				->where('close_date < ?', $date);
		$rows = $table->fetchAll($select);
		if($rows->count() > 0){
			return $rows;
		}else{
			return NULL;
		}
	}

	public function getTestAverages($tests)
	{
		$table = new Model_TestScores();    
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('t' => 'test_scores'), array('t.test_id', 'AVG(score) AS avg'));
				$i = 0;
		foreach($tests as $test){
			if($i == 0){
				$select->where('t.test_id = ?', $test->test_id);
			}else{
				$select->orWhere('t.test_id = ?', $test->test_id);
			}
			$i++;
		}
		$select->group('t.test_id');
		$rows = $table->fetchAll($select);
		if($rows->count() > 0){
			return $rows;
		}else{
			return NULL;
		}
	}
	

	public function getStudentClasses($id)
	{
		$table = new Model_Course();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('c' => 'courses'), array('c.id AS course_id', 'c.subject', 'c.year'))
				->join(array('cl' => 'classes'), 'cl.course_id = c.id', array('cl.name', 'cl.id AS class_id'))    
				->join(array('cl_e' => 'class_enrolment'), 'cl_e.class_id = cl.id', array('cl_e.id AS cl_e_id'))    
				->where('cl_e.user_id = ?', $id);
		return $rows = $table->fetchAll($select);

	}

	public function getTestQuestions($testID)
	{
		$table = new Model_Question();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('q' => 'questions'), array('q.id', 'q.number', 'q.answer', 'q.worth'))
				->where('q.test_id = ?', $testID);
		return $rows = $table->fetchAll($select);
	}

	public function getStudentAnswers($questionID)//might not need this one//
	{
		$table = new Model_StudentAnswers();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false)
				->where('question_id = ?', $questionID);
		return $rows = $table->fetchAll($select);
	}

	public function getClassMembers($classID)//might not need this one//
	{
		$table = new Model_Classenrol();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('cl_e' => 'class_enrolment'), array('cl_e.id AS p_id', 'cl_e.status', 'cl_e.notified'))		
				->join(array('u' => 'users'), 'u.id = cl_e.user_id', array('u.id', 'u.username', 'u.first_name', 'u.last_name', 'u.email'))    
				->where('cl_e.class_id = ?', $classID);
		return $rows = $table->fetchAll($select);
	}
	
	public function getCourseEnrolment($courseID)
	{
		$table = new Model_Courseenrol();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('c' => 'course_enrolment'), array('c.user_id'))
				->where('c.course_id = ?', $courseID);
		return $rows = $table->fetchAll($select);
	}

	public function getUserCourseEnrolment($userID)
	{
		$table = new Model_Course();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('c' => 'courses'), array('id', 'subject', 'year'))
				->join(array('c_e' => 'course_enrolment'), 'c_e.course_id = c.id', array())    
				->where('c_e.user_id = ?', $userID);
		return $rows = $table->fetchAll($select);
	}

	public function getTestAvg($testID)
	{
		$table = new Model_TestScores();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('t' => 'test_scores'), array('COUNT(t.score) AS count', 'SUM(t.score) AS sum'))
				->where('t.test_id = ?', $testID);
		return $row = $table->fetchRow($select);
	}


	public function isCourseEnrolable($courseID, $userID)
	{
		$table = new Model_Courseenrol();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false)
				->from(array('c_e' => 'course_enrolment'), array())
				->where('c_e.user_id = ?', $userID)
				->where('c_e.course_id = ?', $courseID);
		$row = $table->fetchRow($select);
		if($row){
			return false;
		}else{
			return true;
		}
	}

	public function getCoursesInSeason()
	{
		$table = new Model_Course();    
		// retrieve with from part set, important when joining
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
		$select->setIntegrityCheck(false)
				->where('status = ?', 'Ready')
				->orWhere('status = ?', 'In Progress');
		$rows = $table->fetchAll($select);
		if($rows->count() > 0){
			return $rows;
		}else{
			return NULL;
		}
	}

    public function getCourseEnrolCount ()
    {
		$table = new Model_Course();    
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->from(array('c' => 'courses'), array('c.subject', 'c.year'));
		$select->join(array('ce' => 'course_enrolment'), 'ce.course_id = c.id', array('COUNT(ce.course_id) AS ce_count'));
		$select->group('c.subject');
        $select->order('c.subject');
        $count = $table->fetchAll($select);
        if ($count->count() > 0) {
            return $count;
        } else {
            return null;
        }
    }

    public function getGeneralTestInfo ($id)
    {
		$table = new Model_Test();    
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->from(array('t' => 'tests'), array('t.number', 't.name'));
		$select->where('t.course_id = ?', $id);
		$select->join(array('q' => 'questions'), 'q.test_id = t.id', array('SUM(q.worth) AS test_sum', 'COUNT(q.test_id) AS question_count'));
		$select->group('t.number');
        $select->order('t.number');
        $count = $table->fetchAll($select);
        if ($count->count() > 0) {
            return $count;
        } else {
            return null;
        }
    }

    public function getAllTestsBySubject ()
    {
		$table = new Model_Test();    
		$select = $table->select(Zend_Db_Table::SELECT_WITHOUT_FROM_PART);
		$select->setIntegrityCheck(false);
		$select->from(array('t' => 'tests'), array('*'));
		$select->join(array('c' => 'courses'), 'c.id = t.course_id', array('c.subject'));
        $select->order(array('c.subject', 't.number'));
        $rows = $table->fetchAll($select);
        if ($rows->count() > 0) {
            return $rows;
        } else {
            return null;
        }
    }
	
}
?>