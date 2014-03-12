<?php
class Admin_Form_Mark extends Zend_Dojo_Form
{

    public function init()
    {
        $this->setMethod('post');
		$e = new stdClass;
        // create new element
        $e->id = $this->createElement('hidden', 'id');
        // element options
        $e->id->setDecorators(array('ViewHelper'));
        // add the element to the form
        $this->addElement($e->id);

		$e->choices = new Zend_Dojo_Form_Element_RadioButton('choices');
		$e->choices->setLabel('Marking Options:');
		$e->choices->setRequired(true);
		$e->choices->setMultiOptions( array(
												'last' => 'Last Full Week',
												'single' => 'Single Week',
												'all' => 'All Weeks',
											));
		$e->choices->setValue('last');
        $this->addElement($e->choices);
		
		$e->monday_date = new Zend_Dojo_Form_Element_ComboBox('monday_date');
		$e->monday_date->setLabel('Monday:');
		$e->monday_date->setRequired(true);
		$e->monday_date->setOptions(array('invalidMessage' => 'Invalid Date specified.'));
		$e->monday_date->setAutoComplete('true');
		$e->monday_date->setMultiOptions(array('2012-09-24' => '2012-09-24'));
        $this->addElement($e->monday_date);

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
}
?>
