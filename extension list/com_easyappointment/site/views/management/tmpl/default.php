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

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=management', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
		
		<?php echo MedialDisplay::loadMenu() ;?>

		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><i class="ico ico-home"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_DASHBOARD');?></h3>
		    </div>
		</div>

		<div class="row text-center">
			<button class="btn btn-lg" onclick="bnew();return false;"><i class="ico ico-add"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_NEW_BOOKING');?></button>
		</div>
		
		<div class="row spacer"></div>
		
		<?php if ($this->bookings) { ?>
		<h4 class="text-center"><?php echo JText::_('COM_EASYAPPOINTMENT_YOUR_TODAY_BOOKINGS');?></h4>
		<table class="table table-hover">
			<thead>
				<tr>
					<th><i class="ico ico-clock"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_FROM_HOUR');?> <i class="ico ico-go-right"></i></th>
					<th><i class="ico ico-go-left"></i> <i class="ico ico-clock"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_TO_HOUR');?></th>
					<th><i class="ico ico-flag"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SERVICE');?></th>
					<th><i class="ico ico-user"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLIENT');?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php foreach ($this->bookings as $booking) {?>
					<tr>
						<td><?php echo MedialDisplay::showTime($booking->startingTime, $this->staff->getParams()->get('hour_format')); ?></td>
						<td><?php echo MedialDisplay::showTime($booking->endingTime, $this->staff->getParams()->get('hour_format')); ?></td>
						<td><?php echo MedialService::getInstance($booking->service)->get('name'); ?></td>		
						<td><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&task=booking.edit&id=' . $booking->id);?>"><?php echo $this->escape($booking->name);?></a></td>	
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>
		
		<div class="row spacer"></div>
		
		<div class="row">
			<h4 class="text-center"><?php echo JText::_('COM_EASYAPPOINTMENT_YOUR_SERVICES');?></h4>
			<?php if ($this->staff->getServices()) { foreach ($this->staff->getServices() as $service) { { ?>
				<p class="text-center"><?php echo $service->name;?></p>
			<?php } } }  ?>
		</div>
		
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>


<script type="text/javascript">	  
	function bnew() {
		document.adminForm.task.value = 'booking.add';
		document.adminForm.submit();
	}
</script>
