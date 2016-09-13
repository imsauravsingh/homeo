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
JHtml::_('behavior.modal', 'a.mod');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'staff.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div id="easyapp">
	
	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=staff&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
		
		<div class="row">
			<div class="col-md-12 form-horizontal">
			<legend><?php echo JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS'); ?></legend>
				<?php $fields = array('name','published', 'user',  'picture', 'description', 'id', 'schedules');  
					foreach ( $fields as $field ) { ?>
			
					<div class="form-group">
							<label class="control-label col-md-2">
								<?php echo $this->form->getLabel($field); ?>
							</label>
						<div class="controls col-md-10">
							<?php echo $this->form->getInput($field); ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
