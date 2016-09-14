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

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=special', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
		
		<?php echo MedialDisplay::loadMenu() ;?>

		<!-- add new interval form -->
		<div id="addSchedule">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_WORKING_INTERVALS');?></h3>
				</div>

				 <div class="panel-body">
					
					<div class="form-group">
						<select class="input-lg col-md-offset-1 col-md-3" id="addStart">
							<option value="0"> - <?php echo JText::_('COM_EASYAPPOINTMENT_SELECT_START_HOUR') ;?> - </option>
							<?php echo JHtml::_('select.options', $this->user->getSchedule()->getDefaultHours()) ;?>
						</select>
					</div>

					<div class="form-group">
						<select class="input-lg col-md-offset-1 col-md-3" id="addEnd">
							<option value="0"> - <?php echo JText::_('COM_EASYAPPOINTMENT_SELECT_END_HOUR') ;?> - </option>
							<?php echo JHtml::_('select.options', $this->user->getSchedule()->getDefaultHours()) ;?>
						</select>
					</div>

					<div class="form-group">
						<div class="col-md-offset-1">
							<button class="input-lg btn btn-default" id="btn-add-save"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
							<button class="input-lg btn btn-default" id="btn-add-cancel"><i class="ico ico-close"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLOSE');?></button>
						</div>
					</div>
			
				</div>
			</div>
		</div>
		<!-- /add new interval form -->

		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_SPECIAL_DATE');?></h3>
		    </div>
		</div>

		<div class="row tbb-action">
			<div class="col-md-12">
				<button class="btn" id="btn-save"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
				<button class="btn" id="btn-close"><i class="ico ico-close"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLOSE');?></button>
				<?php if (!$this->item->date) {?> 
				<button class="btn" id="btn-add"><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_WORKING_INTERVALS');?></button>
				<?php } ?>
			</div>
		</div>

		<?php $fieldset = $this->form->getFieldset('details'); foreach ($fieldset as $field) { ?>
		<div class="form-group">
			<label class="control-label col-md-2"> <?php echo $field->label; ?> </label>
			<div class="controls cold-md-10">
				<?php echo $field->input; ?>
			</div>
		</div>
		<?php } ?>

		<table class="table" id="intervals">
			<thead>
				<tr><th colspan="2"><?php echo JText::_('COM_EASYAPPOINTMENT_INTERVALS');?></th></tr>
			</thead>
			<tbody>
				<?php if ($this->item->intervals) { foreach ($this->item->intervals as $interval) { ?>
				<tr>
					<td><?php echo MedialDisplay::showTime($interval['start'], $this->user->getParams()->get('hour_format')); ?></td>
					<td><?php echo MedialDisplay::showTime($interval['end'], $this->user->getParams()->get('hour_format')); ?></td>
				</tr>
				<?php } } ?>
			<tbody>
		</table>
			
		<input type="hidden" name="timestamp" id="timestamp" />
		<input type="hidden" name="task" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>



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
new datepickr('jform_calendar', 'jform_calendar', DateConfig);
tbb.return = '<?php echo JRoute::_('index.php?option=com_easyappointment&view=schedules#special', false);?>';
tbb.user = <?php echo $this->user->id ; ?>;
tbb.token = '<?php echo JFactory::getSession()->getFormToken();?>=1';
tbb.root = '<?php echo JUri::root();?>';
<?php if ($this->form->getValue('date')) { ?>
document.getElementById('jform_calendar').value = "<?php echo MedialDisplay::showDate($this->form->getValue('date'), $this->user->getParams()->get('date_format'));?>";
<?php } ?>
</script>
