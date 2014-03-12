<?php
class Admin_Form_Question extends Zend_Dojo_Form
{

    public function init()
    {
		$mdl_Sport = new Model_Qotdsports();
		$sports = $mdl_Sport->get_all();
		$arr_sports = array();
		foreach($sports as $sport)
		{
			$arr_sports[$sport->id] = $sport->sport;
		}
		
        $this->setMethod('post');
		$e = new stdClass;
        // create new element
        $e->id = $this->createElement('hidden', 'id');
        // element options
        $e->id->setDecorators(array('ViewHelper'));
        // add the element to the form
        $this->addElement($e->id);

		$e->close_date = new Zend_Dojo_Form_Element_DateTextBox('close_date');
		$e->close_date->setLabel('Close Date:');
		$e->close_date->setRequired(true);
		$e->close_date->setOptions(array('invalidMessage' => 'Invalid date specified.', 'formatLength'   => 'long'));
        $this->addElement($e->close_date);

		$e->close_time = new Zend_Dojo_Form_Element_TimeTextBox('close_time');
		$e->close_time->setLabel('Close Time:');
		$e->close_time->setRequired(true);
		$e->close_time->setVisibleRange('T04:00:00');
		$e->close_time->setVisibleIncrement('T01:00:00');
		$e->close_time->setClickableIncrement('T00:05:00');
        $this->addElement($e->close_time);

		$e->sport = new Zend_Dojo_Form_Element_FilteringSelect('sport');
		$e->sport->setLabel('Sport:');
		$e->sport->setRequired(true);
		$e->sport->setOptions(array('invalidMessage' => 'Invalid Date specified.'));
		$e->sport->setAutoComplete('true');
		$e->sport->setMultiOptions($arr_sports);
 		$e->sport->setValue(1);
      	$this->addElement($e->sport);

		$e->question = new Zend_Dojo_Form_Element_Editor('question');
		$e->question->setLabel('Question:');
		$e->question->setRequired(true);
		$e->question->setOptions(array('height' => '200'));
        $this->addElement($e->question);
		
		$e->ch_a = new Zend_Dojo_Form_Element_Editor('ch_a');
		$e->ch_a->setLabel('A:');
		$e->ch_a->setRequired(true);
		$e->ch_a->setOptions(array('height' => '200'));
        $this->addElement($e->ch_a);
		
		$e->ch_b = new Zend_Dojo_Form_Element_Editor('ch_b');
		$e->ch_b->setLabel('B:');
		$e->ch_b->setRequired(true);
		$e->ch_b->setOptions(array('height' => '200'));
        $this->addElement($e->ch_b);

		$e->ch_c = new Zend_Dojo_Form_Element_Editor('ch_c');
		$e->ch_c->setLabel('C:');
		$e->ch_c->setOptions(array('height' => '200'));
        $this->addElement($e->ch_c);
		
		$e->ch_d = new Zend_Dojo_Form_Element_Editor('ch_d');
		$e->ch_d->setLabel('D:');
		$e->ch_d->setOptions(array('height' => '200'));
        $this->addElement($e->ch_d);

		$e->ch_e = new Zend_Dojo_Form_Element_Editor('ch_e');
		$e->ch_e->setLabel('E:');
		$e->ch_e->setOptions(array('height' => '200'));
        $this->addElement($e->ch_e);
		
		// Submit
		$e->submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
		$e->submit->setLabel('Submit');
		$e->submit->removeDecorator('DtDdWrapper');
		$this->addElement($e->submit);
		
		// Cancel
		$e->cancel = new Zend_Dojo_Form_Element_SubmitButton('cancel');
		$e->cancel->setLabel('Cancel');
		$e->cancel->removeDecorator('DtDdWrapper');
		$this->addElement($e->cancel);
		
		// Buttons Display Group
		$this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
		$dg = $this->getDisplayGroup('buttons');
		$dg->removeDecorator('Fieldset');
		$dg->removeDecorator('HtmlTag');

    }
	
	public function populate_req($data)
	{
		if($data != NULL)
		{
			$this->getElement('id')->setValue($data->id);	
			$this->getElement('close_date')->setValue($data->close_date);	
			$this->getElement('close_time')->setValue('T' . $data->close_time);	
			$this->getElement('question')->setValue($data->question);	
			$this->getElement('ch_a')->setValue($data->ch_a);	
			$this->getElement('ch_b')->setValue($data->ch_b);	
		}
		
	}

	public function populate_not_req($data)
	{
		if($data != NULL)
		{
			foreach($data as $row)
			{
				$this->getElement($row->description)->setValue($row->value);	
			}
		}
	}
	
	public function setup_create_action()
	{
		$this->getElement('close_date')->addValidator(new Zend_Validate_Db_NoRecordExists(array('table' => 'questions','field' => 'close_date')));
	}

	public function populate_sport($data)
	{
		if($data != NULL)
		{
			$this->getElement('sport')->setValue($data);	

		}
	}
}
?>
