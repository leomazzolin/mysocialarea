<?php
class Zend_View_Helper_Questiondata1 extends Zend_View_Helper_Abstract
{
    public function Questiondata1 ( $row )
    {
		switch ($row->description)
		{
		case 'ch_c':
			?>
			<fieldset><legend>CHOICE C:</legend>
            <p><?php echo $row->value ?></p>
            </fieldset>
            <br />
            <?php
			break;
		case 'ch_d':
			?>
			<fieldset><legend>CHOICE D:</legend>
            <p><?php echo $row->value ?></p>
            </fieldset>
            <br />
            <?php
			break;
		case 'ch_e':
			?>
			<fieldset><legend>CHOICE E:</legend>
            <p><?php echo $row->value ?></p>
            </fieldset>
            <br />
            <?php
			break;
		default:
			return NULL;
		  	break;
		}
    }
}
?>