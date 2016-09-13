<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'service.cancel' || document.formvalidator.isValid(document.id('appointment-form'))) {
			Joomla.submitform(task, document.getElementById('appointment-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<div id="easyapp">
	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=service&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="appointment-form" class="form-validate form-horizontal">
		
		<fieldset>

			<?php $fields = array('name', 'parent', 'length', 'price', 'description', 'id');  
				foreach ( $fields as $field ) {?>
			
				<div class="form-group">
					<label class="control-label col-md-2"> <?php echo $this->form->getLabel($field); ?> </label>
					<div class="controls col-md-10">
						<?php echo $this->form->getInput($field); ?>
					</div>
				</div>
			<?php } ?>

		</fieldset>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
