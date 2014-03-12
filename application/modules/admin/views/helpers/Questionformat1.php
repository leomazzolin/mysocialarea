<?php
class Zend_View_Helper_Questionformat1 extends Zend_View_Helper_Abstract
{
    public function Questionformat1 ( $data )
    {
		switch ($data->description)
		{
		case 'ch_c':
			if($data->value != NULL)
			{?>
                <tr>
                <th>C:</th>
                <td><?php echo $data->value; ?></td>
                </tr>
            <?php
			}
			break;
		case 'ch_d':
			if($data->value != NULL)
			{?>
                <tr>
                <th>D:</th>
                <td><?php echo $data->value; ?></td>
                </tr>
            <?php
			}
			break;
		case 'ch_e':
			if($data->value != NULL)
			{?>
                <tr>
                <th>E:</th>
                <td><?php echo $data->value; ?></td>
                </tr>
            <?php
			}
			break;
		default:
			return NULL;
		  	break;
		}
    }
}
?>