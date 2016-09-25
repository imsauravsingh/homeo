<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<div id="easyapp">

	<?php if($this->user->getParams()->get('client_must_be_registered') && !$this->client->id) { ?>
		<p><?php echo JText::_('COM_EASYAPPOINTMENT_CLIENT_MUST_BE_REGISTERED_PROHIBITED');?></p>
	<?php } else { ?>

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=information');?>" method="post" id="infoForm" name="infoForm">

	<?php echo MedialDisplay::showFormSteps('information', $this->user->getParams()->get('client_must_confirm')); ?>

	<div class="row">
		<div class="col-md-6 information">
			<p><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_INFORMATION_TO_CONTINUE');?></p>
			<p><?php echo JText::_('COM_EASYAPPOINTMENT_ASTERIX_REQUIRED'); ?>
			<?php foreach ( $this->form->getFieldset('details') as $field ) { ?>
			<div class="form-group">
				<label><?php echo $field->label; ?></label><?php echo $field->input; ?>
			</div>
			<?php } ?>
			<div class="form-group">
				<button id="continue" class="form-control input-lg continue"><?php echo JText::_('COM_EASYAPPOINTMENT_CONTINUE');?></button>
			</div>
		</div>

		<div class="col-md-6">
			<div class="details">
				<div class="details-header">
					<h4><i class="ico ico-calendar"></i> <?php echo MedialDisplay::showDate($this->form->getValue('appointmentDate'), $this->user->getParams()->get('date_format'));?></h4>
					<h4><i class="ico ico-clock"></i> <?php echo MedialDisplay::showTime($this->form->getValue('startingTime'), $this->user->getParams()->get('hour_format'));?></h4>
				</div>
				<div class="details-body row">
          <?php include "info_userheader.php"; ?>
				</div>
			</div>
			<?php foreach ( $this->form->getFieldset('details-hidden') as $field ) { echo $field->input; } ?>
		</div>
	</div>


	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
	</form>
	<?php } ?>
</div>
