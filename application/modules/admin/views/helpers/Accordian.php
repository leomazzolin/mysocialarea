<?php
class Zend_View_Helper_Accordian extends Zend_View_Helper_Abstract
{
    public function Accordian( $data )
    {?>
        <div class="accordion jq-custom" style="font-size: 90%;">
        
        <?php
		foreach($data as $d)
		{
			?>
                <h3><a href="#"><?php echo $d['header']; ?></a></h3>
                <div>
                	<?php echo $d['content']; ?>
                </div>
<?php
		}
	?> </div> <?php
	}
}
?>