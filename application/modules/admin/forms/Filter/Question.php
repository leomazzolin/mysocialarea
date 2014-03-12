<?php
class Admin_Form_Filter_Question extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setMethod('post');
		/*
        // create new element
        $e['id'] = $this->createElement('hidden', 'id');
        // element options
        $e['id']->setDecorators(array('ViewHelper'));
        // add the element to the form
        $this->addElement($e['id']);
		*/

		$e['year'] = new Zend_Dojo_Form_Element_ComboBox('year');
		$e['year']->setLabel('Year:');
		$e['year']->setRequired(true);
		$e['year']->setOptions(array('invalidMessage' => 'Invalid year specified.'));
		$e['year']->setAutoComplete('true');
		$e['year']->setMultiOptions(array('all' => 'All', '2012' => '2012', '2013' => '2013'));
        $this->addElement($e['year']);

		$e['month'] = new Zend_Dojo_Form_Element_ComboBox('month');
		$e['month']->setLabel('Month:');
		$e['month']->setRequired(true);
		$e['month']->setOptions(array('invalidMessage' => 'Invalid month specified.'));
		$e['month']->setAutoComplete('true');
		$e['month']->setMultiOptions(	array(	'All' => 'All',
												'01' => 'January',
												'02' => 'Febuary',
												'03' => 'March',
												'04' => 'April',
												'05' => 'May',
												'06' => 'June',
												'07' => 'July',
												'08' => 'August',
												'09' => 'September',
												'10' => 'October',
												'11' => 'November',
												'12' => 'December'
											)
									);
        $this->addElement($e['month']);
		
		// Submit
		$submit = new Zend_Dojo_Form_Element_SubmitButton('submit');
		$submit->setLabel('Submit');
		$submit->removeDecorator('DtDdWrapper');
		$this->addElement($submit);
		
		// Cancel
		$cancel = new Zend_Dojo_Form_Element_SubmitButton('cancel');
		$cancel->setLabel('Reset');
		$cancel->removeDecorator('DtDdWrapper');
		$this->addElement($cancel);
		
		// Buttons Display Group
		$this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
		$dg = $this->getDisplayGroup('buttons');
		$dg->removeDecorator('Fieldset');
		$dg->removeDecorator('HtmlTag');

    }
	
	public function format_month($data)
	{
		$months = array(	'All' => 'All',
							'January' => '01',
							'Febuary' => '02',
							'March' => '03',
							'April' => '04',
							'May' => '05',
							'June' => '06',
							'July' => '07',
							'August' => '08',
							'September' => '09',
							'October' => '10',
							'November' => '11',
							'December' => '12'
						);
		return $months[$data];
	}

}
?>
