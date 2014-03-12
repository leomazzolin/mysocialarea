<?php
class Zend_View_Helper_Submenu extends Zend_View_Helper_Abstract
{
    public function Submenu ($arr = NULL)
    {
		if($arr != NULL)
        {
		?>
        <div data-dojo-type="dijit/MenuBar" id="navMenu1" style="margin: 3px 5px 5px 5px;">
        	<?php
			foreach($arr as $key => $val)
			{
				?>
            <div data-dojo-type="dijit/MenuBarItem" data-dojo-props="onClick:function(){window.location.href = '<?php echo $val; ?>';}"><?php echo $key; ?></div>
            <?php
			}
			?>
        </div>
    	<?php
		}
    }
}
?>