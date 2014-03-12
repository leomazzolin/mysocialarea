<?php
class Admin_Form_Answer extends Zend_Dojo_Form
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

		$e['answer'] = new Zend_Dojo_Form_Element_ComboBox('answer');
		$e['answer']->setLabel('Answer:');
		$e['answer']->setRequired(true);
		$e['answer']->setOptions(array('invalidMessage' => 'Invalid answer specified.'));
		$e['answer']->setAutoComplete('true');
		$e['answer']->setMultiOptions(array('a' => 'A', 'b' => 'B', 'c' => 'C',  'd' => 'D', 'e' => 'E'));
        $this->addElement($e['answer']);

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
	
}
?>
