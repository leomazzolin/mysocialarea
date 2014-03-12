<?php
class Zend_View_Helper_Result1 extends Zend_View_Helper_Abstract
{
    public function Result1 ( $data )
    {
		if ($data->answer == '-')
		{ 
			return '-';
		}
		else
		{
			if ($data->answer == $data->choice)
			{ 
				return 'CORRECT!';
			}
			else
			{ 
				return 'INCORRECT';
			}
        }

    }
}
?>