<?php
class Zend_View_Helper_Messages1 extends Zend_View_Helper_Abstract
{
    public function Messages1 ()
    {
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		
		 if ($flashMessenger->setNamespace('notice')->hasMessages()): ?>
			<div class="flash notice">
            <fieldset><legend>NOTICE:</legend>
			<?php foreach ($flashMessenger->getMessages() as $msg): ?>
				<?php echo $msg ?>
			<?php endforeach; ?>
            </fieldset>
			</div>
		<?php endif; ?>
		
		<?php if ($flashMessenger->setNamespace('success')->hasMessages()): ?>
			<div class="flash success">
            <fieldset><legend>SUCCESS:</legend>
			<?php foreach ($flashMessenger->getMessages() as $msg): ?>
				<?php echo $msg ?>
			<?php endforeach; ?>
            </fieldset>
			</div>
		<?php endif; ?>

		<?php if ($flashMessenger->setNamespace('error')->hasMessages()): ?>
			<div class="flash error">
            <fieldset><legend>ERROR:</legend>
			<?php foreach ($flashMessenger->getMessages() as $msg): ?>
				<?php echo $msg ?>
			<?php endforeach; ?>
            </fieldset>
			</div>
		<?php endif; ?>

		<?php if ($flashMessenger->setNamespace('instructions')->hasMessages()): ?>
			<div class="flash instructions">
			<?php foreach ($flashMessenger->getMessages() as $msg): ?>
				<?php echo $msg ?>
			<?php endforeach; ?>
			</div>
		<?php endif;
    }
}
?>