<?php
class Zend_View_Helper_Admin_Pagetitle extends Zend_View_Helper_Abstract
{
    public function Admin_Pagetitle ( $form, $title )
    {?>
    	<div style="height:50px; border: 1px solid black; width: 97%; padding-left: 10px; padding-right: 10px; background-color:#FFC;">
            <div style="float:left; width:22%;">
                <?php echo $form; ?>
            </div>
            <div style="float:left; width:78%; height: 50px;">
                <h2 align="center" style="padding-top:10px;"><?php echo $title; ?></h2>
            </div>
        </div>
	<?php
    }
}

?>