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
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'appointment.cancel' || document.formvalidator.isValid(document.id('appointment-form'))) {
			Joomla.submitform(task, document.getElementById('appointment-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div id="easyapp">
	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=appointment&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="appointment-form" class="form-validate form-horizontal">

		<fieldset>
			<?php $fields = array('staff', 'service', 'appointmentDateV' , 'startingTimeV', 'endingTimeV','published','name', 'email', 'phone', 'address', 'comments', 'id');  
				foreach ( $fields as $field ) {?>
				<div class="row">
					<div class="col-md-2"><?php echo JText::_($this->form->getFieldAttribute($field,'label')); ?></div>
					<div class="col-md-10"><?php echo $this->escape($this->form->getValue($field)); ?></div>
				</div>
			<?php } ?>
		</fieldset>
		
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
