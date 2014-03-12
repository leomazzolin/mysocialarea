<?php
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
    public function Menu ()
    {
		?>
        <div data-dojo-type="dijit/DropDownMenu" id="navMenu" style="width: 215px; font-size: 22px;">
            <div data-dojo-type="dijit/PopupMenuItem">
                <span>MAIN MENU:</span>
                <div data-dojo-type="dijit/DropDownMenu" id="submenu1">
                    <div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/';}">HOME</div>
                    <div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/default/user/profile';}">MY PROFILE</div>
                    <div data-dojo-type="dijit/MenuSeparator"></div>
                        <div data-dojo-type="dijit/PopupMenuItem">
                            <span>SECTIONS:</span>
                            <div data-dojo-type="dijit/DropDownMenu" id="submenu1-1">
                                <div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/default/pss/index';}">PET SOCIAL SPACE</div>
                                <!--<div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/default/mlse/index';}">MLSE ON TRIAL</div>
                                <div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/op/index/index';}">OPINION POLLS</div>-->
                            </div>
                        </div>
                    <div data-dojo-type="dijit/MenuSeparator"></div>
                    <div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/default/contact/index';}">CONTACT US</div>
                    <div data-dojo-type="dijit/MenuItem" data-dojo-props="onClick:function(){window.location.href = '/default/help/index';}">HELP</div>
                </div>
            </div>
        </div>
    	<?php
    }
}
?>