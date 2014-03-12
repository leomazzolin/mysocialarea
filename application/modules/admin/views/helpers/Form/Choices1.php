<?php
class Zend_View_Helper_Form_Choices1 extends Zend_View_Helper_Abstract
{
	
    public function Form_Choices1 ( $data, $userChoice )
    {
		$u = new Model_My_Utility();
		$choices = $data->choices;
		sort($choices);
		$ctr = 0;
		foreach($choices as $choice)
		{
			$ctr++; ?>
            <fieldset style="width: 620px; background-color:#FFC; margin: auto;">
                <legend style="font-size:120%; font-weight: bold; background-color: #FFF;">
                    <label><?php echo $choice; ?>&nbsp;&nbsp;</label>
                        <input 
                        	type="radio" 
                            name="rg-1" 
                            value="<?php echo str_replace(' ', '', $choice); ?>" 
                            id="rg-<?php echo str_replace(' ', '', $choice); ?>"
                            <?php
							if( $userChoice == str_replace(' ', '', $choice) )
							{?>
                            	checked="checked"
                            <?php
							}
							?>
                             />&nbsp;
                </legend>
                    <img src="/images/opinion_poll/<?php echo strtolower(str_replace(' ','_', $data->category)) . '/' . strtolower(str_replace(' ','_', $data->poll_name)) . '/' . strtolower(str_replace(' ','', $choice)) . '_1.jpg'; ?>" width="200" >
                    <img src="/images/opinion_poll/<?php echo strtolower(str_replace(' ','_', $data->category)) . '/' . strtolower(str_replace(' ','_', $data->poll_name)) . '/' . strtolower(str_replace(' ','', $choice)) . '_2.jpg'; ?>" width="200" >
                    <img src="/images/opinion_poll/<?php echo strtolower(str_replace(' ','_', $data->category)) . '/' . strtolower(str_replace(' ','_', $data->poll_name)) . '/' . strtolower(str_replace(' ','', $choice)) . '_3.jpg'; ?>" width="200" >
            </fieldset>
            <br />
			<?php
			if($ctr % 3 == 0)
			{?>
				<a href="#top" style="background-color:#FF3; margin-left: 200px; border: 2px solid #000; padding: 5px;">Back to Top</a>
                <br /><br />
            <?php
			}
		}
    }
}
?>