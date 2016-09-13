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

		<?php //echo MedialDisplay::loadMenu() ;?>

		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><i class="ico ico-settings"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SETTINGS');?></h3>
		    </div>
		</div>

		<div class="topdiv list-inline">
		<li id="tab_general" class="dashboard_li" align="center"><input type="button" value="Genral Setting"/></li>
		<li id="tab_profile" class="dashboard_li" align="center"><input type="button" value="Profile Display"/></li>
		<li id="tab_appointmentform" class="dashboard_li" align="center"><input type="button" value="Client Booking Process"/></li>
		<li id="tab_services" class="dashboard_li" align="center"><input type="button" value="Services"/></li>
		<li id="tab_receive_notification" class="dashboard_li" align="center"><input type="button" value="Receive Notifications"/></li>
		<li id="tab_send_notification"class="dashboard_li" align="center"><input type="button" value="Send Notification"/></li>
		</div>

		<div class="tbb-content settings tab-content">
		<?php $fieldsets = $this->form->getFieldsets(); foreach ($fieldsets as $fieldset) { ?>
			<div class="well dashboard_divli" id="tab_<?php echo strtolower($fieldset->name); ?>">
			<legend><?php echo JText::_('COM_EASYAPPOINTMENT_SETTINGS_' . strtoupper($fieldset->name));?></legend>
			<?php $fields = $this->form->getFieldset($fieldset->name); foreach ( $fields as $field ) { ?>
				<div class="form-group col-md-6 col-sm-6 col-xs-12">
					<label class="control-label col-md-6 f_left"> <?php echo $field->label; ?> </label>
					<div class="controls cold-md-6">
						<?php echo $field->fieldname == 'tags' ? JText::_('COM_EASYAPPOINTMENT_NOTIFICATIONS_TAGS') : $field->input; ?>
					</div>
				</div>
			<?php } ?>
			
			<div class="row tbb-action">				
				<div class="col-md-12 text-center">	
				<div class="col-md-offset-3 input_line text-center"></div>
					<button class="btn" onclick="tbb.save();"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
				</div>
			</div>
			</div>
		<?php } ?>
		</div>

		<input type="hidden" name="timestamp" id="timestamp" />
		<input type="hidden" name="task" value="" />
    <input type="hidden" name="Itemid" value="497" />
		<?php echo JHtml::_('form.token'); ?>
	</form>

</div>
