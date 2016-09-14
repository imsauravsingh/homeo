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

	<?php echo MedialDisplay::showFormSteps('finished', $this->user->getParams()->get('client_must_confirm')); ?>

	<?php if ($this->user->getParams()->get('send_email')) { ?>
	<p><?php echo sprintf(JText::_('COM_EASYAPPOINTMENT_EMAIL_SENT_ALSO'),$this->item['email']);?></p>
	<?php } ?>

	<div class="row">
		<div class="col-md-12">
			<div class="well finished">
				<h2><?php echo JText::_('COM_EASYAPPOINTMENT_YOUR_RESERVATION_DETAILS');?></h2>
			
				<div class="col-md-6">
					<h4><i class="ico ico-calendar"></i> <?php echo MedialDisplay::showDate($this->item['appointmentDate'], $this->user->getParams()->get('date_format'));?></h4>
					<h4><i class="ico ico-clock"></i> <?php echo MedialDisplay::showTime($this->item['startingTime'], $this->user->getParams()->get('hour_format'));?></h4>
					<h4><i class="ico ico-bookings"></i> <?php echo $this->service->name;?></h4>
				</div>

				<div class="col-md-6">
					<p></p>
					<div class="col-md-6">
						<img src="<?php echo JUri::root();?><?php echo $this->user->picture ? $this->escape($this->user->picture) : '/components/com_easyappointment/assets/img/default.png';?>" height="96" width="96" />
					</div>
					<div class="col-md-6">
						<h3><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id='.$this->user->id.'&service=' . $this->service->id);?>"><?php echo $this->escape($this->user->name);?></a></h3>
						<p><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse&category=' . $this->service->id);?>"><?php echo $this->escape($this->service->name);?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
