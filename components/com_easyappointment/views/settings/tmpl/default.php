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

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=settings', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
		
		<?php echo MedialDisplay::loadMenu() ;?>
		
		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><i class="ico ico-settings"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SETTINGS');?></h3>
		    </div>
		</div>

		<div class="row tbb-action">
			<div class="col-md-9 pull-left">
				<button class="btn" onclick="tbb.save();"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
			</div>
		</div>

		<div class="tbb-content settings">
		<?php $fieldsets = $this->form->getFieldsets(); foreach ($fieldsets as $fieldset) { ?>
			<div class="well">
			<legend><?php echo JText::_('COM_EASYAPPOINTMENT_SETTINGS_' . strtoupper($fieldset->name));?></legend>
			<?php $fields = $this->form->getFieldset($fieldset->name); foreach ( $fields as $field ) { ?>
				<div class="form-group">
					<label class="control-label col-md-4"> <?php echo $field->label; ?> </label>
					<div class="controls cold-md-8">
						<?php echo $field->fieldname == 'tags' ? JText::_('COM_EASYAPPOINTMENT_NOTIFICATIONS_TAGS') : $field->input; ?>
					</div>
				</div>
			<?php } ?>
			</div>
		<?php } ?>
		</div>

		<input type="hidden" name="timestamp" id="timestamp" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
