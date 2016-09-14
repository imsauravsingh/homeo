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

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=booking&layout=edit', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
		
		<?php echo MedialDisplay::loadMenu() ;?>

		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><?php echo $this->item->id ? JText::_('COM_EASYAPPOINTMENT_EDIT_BOOKING') : JText::_('COM_EASYAPPOINTMENT_NEW_BOOKING');?></h3>
		    </div>
		</div>

		<div class="row tbb-action">
			<div class="col-md-12">
				<button class="btn" onclick="tbb.save();return false;"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
				<button class="btn" onclick="tbb.close();return false;"><i class="ico ico-close"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLOSE');?></button>
			</div>
		</div>

		<!-- display errors -->
		<div id="error-display" class="alert alert-danger hidden" role="alert"></div>
		<!-- /display errors -->
		
		<?php foreach ( $this->form->getFieldset('details') as $field ) { ?> 
		<div class="form-group">
			<label class="control-label col-md-2"> <?php echo $field->label; ?> </label>
			<div class="controls cold-md-10">
				<?php echo $field->input; ?>
			</div>
		</div>
		<?php } ?>
		
		<input type="hidden" name="timestamp" id="timestamp" />
		<input type="hidden" name="task" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>


<script>
	var DateConfig = {
		fullCurrentMonth: true,
		dateFormat: '<?php echo $this->staff->getParams()->get('date_format');?>',
		weekdays: [<?php echo MedialDisplay::showWeekDays();?>],
		months: [<?php echo MedialDisplay::showMonths();?>],
		suffix: { 1: 'st', 2: 'nd', 3: 'rd', 21: 'st', 22: 'nd', 23: 'rd', 31: 'st' },
		defaultSuffix: 'th', 
		currentTime: 0,
	};
	new datepickr('jform_calendar', 'jform_calendar', DateConfig);
	
	tbb.token = '<?php echo JFactory::getSession()->getFormToken();?>=1';
	tbb.root = '<?php echo JUri::root();?>';
	tbb.user = <?php echo $this->staff->id;?>;
	tbb.startingTime = '<?php echo $this->item->startingTime;?>';
	tbb.endingTime = '<?php echo $this->item->endingTime;?>';
	tbb.endingTimeD = '<?php echo MedialDisplay::showTime($this->item->endingTime, $this->staff->getParams()->get('hour_format'));?>';
	tbb.id = '<?php echo $this->item->id;?>';
	<?php if ($this->form->getValue('appointmentDate')) { ?>
	document.getElementById('jform_calendar').value = "<?php echo MedialDisplay::showDate($this->form->getValue('appointmentDate'), $this->staff->getParams()->get('date_format'));?>";
	<?php } ?>
</script>
