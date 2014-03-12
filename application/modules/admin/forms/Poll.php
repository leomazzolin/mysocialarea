<?php
class Admin_Form_Poll extends Zend_Dojo_Form
{
	protected $_descriptions = array( 'choices' => 'Separate choices with a ;. Also double check correct spelling please!!!');

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

		$e->category = new Zend_Dojo_Form_Element_FilteringSelect('category');
		$e->category->setLabel('Category:');
		$e->category->setRequired(true);
		$e->category->setOptions(array('invalidMessage' => 'Invalid Date specified.'));
		$e->category->setAutoComplete('true');
		$e->category->setMultiOptions(array('Pop Culture' => 'Pop Culture', 'Sports' => 'Sports'));
 		//$e->category->setValue(0);
      	$this->addElement($e->category);

		$e->poll_name = new Zend_Dojo_Form_Element_TextBox('poll_name');
		$e->poll_name->setLabel('Poll Name:');
		$e->poll_name->setRequired(true);
		$e->poll_name->setAttrib('style', 'width: 500px');
		$e->poll_name->setOptions(array('invalidMessage' => 'Invalid Date specified.'));
 		//$e->poll_name->setValue(0);
      	$this->addElement($e->poll_name);

		$e->choices = new Zend_Dojo_Form_Element_Editor('choices');
		$e->choices->setLabel('Choices:');
		$e->choices->setRequired(true);
		$e->choices->setOptions(array('height' => '200'));
		$e->choices->setAttrib('style', 'width: 500px');
		$e->choices->setDescription($this->_descriptions['choices']);
        $this->addElement($e->choices);

		/*
		$e->subcategory = new Zend_Dojo_Form_Element_FilteringSelect('subcategory');
		$e->subcategory->setLabel('Subcategory');
		$e->subcategory->setRequired(true);
		$e->subcategory->setOptions(array('invalidMessage' => 'Invalid Date specified.'));
		$e->subcategory->setAutoComplete('true');
		$e->subcategory->setAttrib('style', 'visibility: hidden');
      	$this->addElement($e->subcategory);
			
		$e->subsubcategory = new Zend_Dojo_Form_Element_FilteringSelect('subsubcategory');
		$e->subsubcategory->setLabel('Sub Subcategory');
		$e->subsubcategory->setRequired(true);
		$e->subsubcategory->setOptions(array('invalidMessage' => 'Invalid Date specified.'));
		$e->subsubcategory->setAutoComplete('true');
      	$this->addElement($e->subsubcategory);
		*/
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
	
	public function _initialize()
	{
		$this->removeElement('subcategory');
		$this->removeElement('subsubcategory');
	}
	
}
?>
