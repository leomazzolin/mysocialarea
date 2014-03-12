<?php
class Zend_View_Helper_Questionformat2 extends Zend_View_Helper_Abstract
{
    public function Questionformat2 ( $data, $status, $choice )
    {
		switch ($data->description)
		{
		case 'ch_c':
			if($data->value != NULL)
			{?>
                <tr>
                    <th>
                 <?php	if($status == 'ready')
                        {?>
                            <label>
                                C&nbsp;<input <?php if($choice == 'C'){ echo 'checked="checked"'; } ?> type="radio" name="answer-question-group" value="c" id="answer-question-group_2" />
                            </label>
                 <?php	}
                        else
                        { ?>
                            C:
                  <?php } ?>			
                    </th>
                    <td><?php echo $data->value; ?></td>
                </tr>
            <?php
			}
			break;
		case 'ch_d':
			if($data->value != NULL)
			{?>

            <tr>
                <th>
			 <?php	if($status == 'ready')
                    {?>
                        <label>
                            D&nbsp;<input <?php if($choice == 'D'){ echo 'checked="checked"'; } ?> type="radio" name="answer-question-group" value="d" id="answer-question-group_3" />
                        </label>
             <?php	}
                    else
                    { ?>
                        D:
              <?php } ?>			
                </th>
                <td><?php echo $data->value; ?></td>
            </tr>
            <?php
			}
			break;
		case 'ch_e':
			if($data->value != NULL)
			{?>

            <tr>
                <th>
			 <?php	if($status == 'ready')
                    {?>
                        <label>
                            E&nbsp;<input <?php if($choice == 'E'){ echo 'checked="checked"'; } ?> type="radio" name="answer-question-group" value="e" id="answer-question-group_4" />
                        </label>
             <?php	}
                    else
                    { ?>
                        E:
              <?php } ?>			
                </th>
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