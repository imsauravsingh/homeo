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

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=bookings', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">

		<?php //echo MedialDisplay::loadMenu() ;?>


		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><?php echo JText::_('COM_EASYAPPOINTMENT_BOOKINGS');?></h3>
		    </div>

		    <div class="col-md-7 tb-span-control">
			  <i id="calendar" class="ico ico-calendar pull-left"></i>
			  <i class="ico ico-go-left pull-left command" onclick="tbb.minus1Day();"></i>
			  <input id="calendar-value" type="text" class="input-sm pull-left" />
			  <i class="ico ico-go-right pull-left command" onclick="tbb.plus1Day();"></i>
			  <i onclick="tbb.viewall();" class="command ico ico-refresh"></i>
		    </div>
		</div>

		<div class="row tbb-action">
			<div class="col-md-8 pull-left">
				<button class="btn" onclick="document.adminForm.task.value='booking.add';document.adminForm.submit();"><i class="ico ico-add"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_NEW');?></button>
				<button class="btn" onclick="tbb.deleteItems();return false;"><i class="ico ico-trash"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_DELETE');?></button>
				<button class="btn" onclick="tbb.exportItems();return false;"><i class="ico ico-export"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_EXPORT');?></button>
			</div>

			<div class="col-md-2 pull-left">
				<select name="filter_service" class="input-sm pull-right" onchange="document.adminForm.submit();">
					<option value="0"><?php echo JText::_('COM_EASYAPPOINTMENT_SERVICE');?></option>
					<?php echo JHtml::_('select.options', $this->user->getServices(), 'id', 'name', $this->state->get('filter.bookings.service'));?>
				</select>
			</div>

			<div class="col-md-2 pull-left">
				<select name="filter_status" class="input-sm pull-right" onchange="document.adminForm.submit();">
					<option value="-1"><?php echo JText::_('COM_EASYAPPOINTMENT_BOOKINGS_STATUS');?></option>
					<?php echo JHtml::_('select.options', $this->statuses, 'value', 'text', $this->state->get('filter.bookings.status'));?>
				</select>
			</div>
		</div>

		<div class="">
				<table class="table table-hover tbb-content">
			<thead>
				<tr>
					<th><input type="checkbox" class="checkbox-id" onclick="tbb.toogleAll();" /></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_CLIENT');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_DATE');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_FROM_HOUR');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_TO_HOUR');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_SERVICE');?></th>
					<th><?php echo JText::_('COM_EASYAPPOINTMENT_ID');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ( $this->bookings ) { foreach ( $this->bookings as $booking ) {?>
				<tr>
					<td><input type="checkbox" name="cid[]" value="<?php echo $booking->id;?>" class="checkbox-id" /></td>
					<td><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&task=booking.edit&id=' . $booking->id);?>"><?php echo $this->escape($booking->name); ?></a></td>
					<td><?php echo MedialDisplay::showDate($booking->appointmentDate, $this->user->getParams()->get('date_format'));?></td>
					<td><?php echo MedialDisplay::showTime($booking->startingTime, $this->user->getParams()->get('hour_format'));?></td>
					<td><?php echo MedialDisplay::showTime($booking->endingTime, $this->user->getParams()->get('hour_format'));?></td>
					<td><?php echo $this->escape(MedialService::getInstance($booking->service)->name);?></td>
					<td><?php echo $booking->id;?></td>
				</tr>
				<?php } } ?>
			</tbody>
			<tfoot>
				<tr class="text-center">
					<td colspan="7">
						<?php echo $this->pagination->getListFooter() ;?>
					</td>
				</tr>
			</tfoot>
		</table>
		</div>


		<div class="row">
			<div class="col-md-3"><i class="ico ico-question"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_UNCONFIRMED');?></div>
			<div class="col-md-3"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CONFIRMED');?></div>
		</div>

		<input type="hidden" name="timestamp" id="timestamp" value="" />
		<input type="hidden" name="filter_bookings_datephp" id="calendar-value-php" value="<?php echo $this->state->get('filter.bookings.datephp');?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>

		<script>
			var DateConfig = {
				fullCurrentMonth: true,
				dateFormat: '<?php echo $this->user->getParams()->get('date_format');?>',
				weekdays: [<?php echo MedialDisplay::showWeekDays();?>],
				months: [<?php echo MedialDisplay::showMonths();?>],
				suffix: { 1: 'st', 2: 'nd', 3: 'rd', 21: 'st', 22: 'nd', 23: 'rd', 31: 'st' },
				defaultSuffix: 'th',
				currentTime: 0,
		  };
		  new datepickr('calendar', 'calendar-value', DateConfig);
		  tbb.root = '<?php echo JUri::root();?>';
			<?php if ($this->state->get('filter.bookings.datephp')) { ?>
			document.getElementById('calendar-value').value = "<?php echo MedialDisplay::showDate($this->state->get('filter.bookings.datephp'), $this->user->getParams()->get('date_format'));?>";
			<?php } ?>
		</script>

	</form>
</div>
