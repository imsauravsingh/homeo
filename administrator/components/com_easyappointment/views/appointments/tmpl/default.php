<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$status	= array( 0=>JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_UNCONFIRMED'), 1=>JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_CONFIRMED') );
?>

	
	

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=appointments'); ?>" method="post" name="adminForm" id="adminForm">

		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
	
		<div id="easyapp">
			<div id="j-main-container" class="span10">
				
				<div id="filter-bar" class="btn-toolbar">
					<div class="btn-group pull-left">
						<input type="text" class="input-sm pull-left" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" />
						<button class="btn btn-default pull-left" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="ico ico-eye"></i></button>
						<button class="btn btn-default pull-left" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="ico ico-close"></i></button>
					</div>
					
					<div class="btn-group pull-left">
						<input type="text" name="filter_date" id="filter_date" class="pull-left input-sm" value="<?php echo $this->state->get('filter.date'); ?>" 
							placeholder="<?php echo $this->state->get('filter.date') ? $this->state->get('filter.date') : JText::_('COM_EASYAPPOINTMENT_SELECT_DATE');?>" />
						<button class="btn btn-default" type="button" onclick="document.id('filter_search').value='';document.id('filter_date').value='';this.form.submit();"><i class="ico ico-close"></i></button>
					</div>

					<div class="btn-group pull-right">
						<select name="filter_status" class="input-sm" onchange="this.form.submit()">
							<option value=""> - <?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_SELECT_STATUS');?> - </option>
							<?php echo JHtml::_('select.options', $status , '', '', $this->state->get('filter.status'));?>
						</select>
					</div>

					<div class="btn-group pull-right">
						<select name="filter_staff" class="input-sm" onchange="this.form.submit()">
							<option value=""> - <?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_SELECT_STAFF');?> - </option>
							<?php echo JHtml::_('select.options', $this->staff  , 'id', 'name', $this->state->get('filter.staff'));?>
						</select>
					</div>

					<div class="btn-group pull-right">
						<select name="filter_service" class="input-sm" onchange="this.form.submit()">
							<option value=""> - <?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_SELECT_SERVICE');?> - </option>
							<?php echo JHtml::_('select.options', $this->services, 'id', 'name', $this->state->get('filter.service'));?>
						</select>
					</div>
				</div>
				
				<div class="clearfix"> </div>
			
			<table class="table  table-striped">
				<thead>
					<tr>
						<th>
							<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
						</th>
							
						<th>
							<?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_APP_NUMBER'); ?>
						</th>
										
						<th>
							<?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_FOR');?>
						</th>

						<th>
							<?php echo JHtml::_('grid.sort', 'COM_EASYAPPOINTMENT_APPOINTMENTS_APP_DATE', 'a.appointmentDate', $listDirn, $listOrder); ?>
						</th>

						<th>
							<?php echo JHtml::_('grid.sort', 'COM_EASYAPPOINTMENT_APPOINTMENTS_APP_INTERVAL', 'a.startingTime', $listDirn, $listOrder); ?>
						</th>

						<th>
							<?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_CLIENT_NAME'); ?>
						</th>

						<th>
							<?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_STATUS'); ?>
						</th>
						
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_EASYAPPOINTMENT_ID', 'a.id', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>

				<tbody>
				<?php foreach ($this->items as $i => $item) {
				?>
				<tr class="row<?php echo $i % 2; ?>">

					<td>
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					
					<td>
						<a href="index.php?option=com_easyappointment&task=appointment.edit&id=<?php echo $item->id;?>"><?php echo $item->keyring;?></a>
					</td>

					<td>
						<?php echo $this->escape($item->staffname); ?>
					</td>
					
					<td>
						<?php echo $this->escape($item->appointmentDate);?>
					</td>
					
					<td>
						<?php echo MedialDisplay::showTime($item->startingTime) . ' - ' . MedialDisplay::showTime($item->endingTime) ;?>
					</td>

					<td>
						<?php echo $this->escape($item->name);?>	
					</td>

					<td>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'appointments.', true, 'cb'); ?>
					</td>
						
					<td>
						<?php echo $item->id; ?>
					</td>
					
				</tr>

				<?php } ?>
				</tbody>
							
				<tfoot>
					<tr>
						<td colspan="8">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
			</table>

			</div>

			<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel"><?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_EXPORT_EMAIL_LIST');?></h3>
				</div>
				<div class="modal-body">
					<label id="jform_basename-lbl" for="jform_basename"><?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_FILENAME');?></label>
					<input type="text" name="jform[basename]" id="jform_basename" value="" class="input-sm" />

					<label id="jform_basename-lbl" for="jform_basename"><?php echo JText::_('COM_EASYAPPOINTMENT_EXPORT_FORMAT');?></label>
					<select name="jform[format]">
						<option value="csv">csv</option>
						<option value="ics">ics</option>
					</select>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_CANCEL');?></button>
					<button class="btn btn-primary" type="button" onclick="Joomla.submitbutton('appointments.export');"><?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_EXPORT');?></button>
				</div>
			</div>
		</div>

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>


<script type="text/javascript">
	var dat = new DateHelper();
	var DateConfig = {
		fullCurrentMonth: true,
		dateFormat: 'Y-m-d',
		weekdays: [<?php echo MedialDisplay::showWeekDays();?>],
		months: [<?php echo MedialDisplay::showMonths();?>],
		suffix: { 1: 'st', 2: 'nd', 3: 'rd', 21: 'st', 22: 'nd', 23: 'rd', 31: 'st' },
		defaultSuffix: 'th', 
		currentTime: 0,
	};
	new datepickr('filter_date', 'filter_date', DateConfig);
	var tbb = {
		changedate : function(d) {
			var timestamp = dat.toTimestamp(d);
        	document.getElementById('filter_date').value = dat.toCustom(timestamp,'Y-m-d');
			document.adminForm.submit();
		},
	};
</script>
