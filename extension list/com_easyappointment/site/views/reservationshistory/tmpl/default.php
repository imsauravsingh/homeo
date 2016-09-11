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
	<?php if (!JFactory::getUser()->get('id')) { ?>
		<p><?php echo JText::_('COM_EASYAPPOINTMENT_MUST_BE_LOGIN');?></p>
	<?php } else { ?>
	
	<?php if ($this->items) { $appointment = new MedialAppointment(); ?>	
		<h3><?php echo JText::_('COM_EASYAPPOINTMENT_RESERVATIONS_HISTORY');?></h3>
		
		<div class="row text-center">
			<a class="btn btn-lg" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse&category=0', false);?>"><i class="ico ico-add"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_NEW_BOOKING');?></a>
		</div>
		
		<table class="table table-striped">
			<thead>
				<tr>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_DATE');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_SERVICE');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_FROM_HOUR');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_TO_HOUR');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_BOOKINGS_STATUS');?></th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($this->items as $item) {  $appointment->load($item->id); $staff_params = MedialStaff::getInstance($appointment->staff)->getParams(); ?>
			<tr>
				<td><?php echo MedialDisplay::showDate($appointment->appointmentDate, $staff_params->get('date_format'));?></td>
				<td><?php echo MedialService::getInstance($appointment->service)->name;?></td>
				<td><?php echo MedialDisplay::showTime($appointment->startingTime, $staff_params->get('hour_format'));?></td>
				<td><?php echo MedialDisplay::showTime($appointment->endingTime, $staff_params->get('hour_format'));?></td>
				<td><?php 
				if ($appointment->published) 
				{ 
					echo JText::_('COM_EASYAPPOINTMENT_CONFIRMED'); 
				} 
				else 
				{ ?>
					<a class="btn btn-sm btn-primary" href="<?php echo JRoute::_('index.php?option=com_easyappointment&task=booking.confirm&k=' . $appointment->keyring . '&e=' . base64_encode($appointment->email), false);?>"><?php echo JText::_('COM_EASYAPPOINTMENT_CONFIRM');?></a>
				<?php } ?>
				</td>
			</tr>
		<?php } ?>
			</tbody>
		</table>
	<?php } } ?>
</div>
