<?php
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    public function Menu ( $menu )
    {?>
			<ul>
            <?php
			foreach($menu as $item )
				{ ?>
           		 <li><a href="<?php echo $item['href'] ?>"><?php echo $item['name'] ?></a></li>
        <?php   } ?>
			</ul>
	<?php
    }
}
?>