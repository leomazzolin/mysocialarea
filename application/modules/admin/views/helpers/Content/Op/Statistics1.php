<?php
class Zend_View_Helper_Content_Op_Statistics1 extends Zend_View_Helper_Abstract
{
    public function Content_Op_Statistics1 ($data)
    {
        $ctr1 = 0;
        foreach($data as $key => $value)
        {
            if($ctr1 % 2 == 0)
            {?>
                <p style="background-color: yellow; width: 30%; display: inline"><?php echo $key; ?>:</p>
                <p style="background-color: yellow; width: 10%; display: inline; padding-left: 10px;"><?php echo $value; ?></p>
                <br clear="all" />
            <?php    
            }
            else
            {?>
                <p style="width: 30%; display: inline"><?php echo $key; ?>:</p>
                <p style="width: 10%; display: inline; padding-left: 10px;"><?php echo $value; ?></p>
                <br clear="all" />

            <?php
            }
            $ctr1++;
        }
    }
}

?>