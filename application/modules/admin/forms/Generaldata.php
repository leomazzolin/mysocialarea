<?php
class Admin_Form_Generaldata extends Zend_Dojo_Form
{

    public function init()
    {
        $this->setMethod('post');

        // create new element
        $e['id'] = $this->createElement('hidden', 'id');
        // element options
        $e['id']->setDecorators(array('ViewHelper'));
        // add the element to the form
        $this->addElement($e['id']);

		$e['context'] = new Zend_Dojo_Form_Element_TextBox('context');
		$e['context']->setLabel('Context:');
		$e['context']->setRequired(true);
		$e['context']->setOptions(array('height' => '200'));
		$e['context']->setMaxLength(100);
        $this->addElement($e['context']);
		
		$e['description'] = new Zend_Dojo_Form_Element_TextBox('description');
		$e['description']->setLabel('Description:');
		$e['description']->setRequired(true);
		$e['description']->setOptions(array('height' => '200'));
		$e['description']->setMaxLength(100);
        $this->addElement($e['description']);
		
		$e['value:'] = new Zend_Dojo_Form_Element_Editor('value:');
		$e['value:']->setLabel('Value:');
		$e['value:']->setRequired(true);
		$e['value:']->setOptions(array('height' => '200'));
        $this->addElement($e['value:']);
		
		// Submit
		$submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
		$submit->setLabel('Submit');
		$submit->removeDecorator('DtDdWrapper');
		$this->addElement($submit);
		
		// Cancel
		$cancel = new Zend_Dojo_Form_Element_SubmitButton('cancel');
		$cancel->setLabel('Cancel');
		$cancel->removeDecorator('DtDdWrapper');
		$this->addElement($cancel);
		
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
	
}
?>
