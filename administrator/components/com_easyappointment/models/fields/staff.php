<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldStaff extends JFormFieldList {

	public function getInput() {
		
		$html 	= array();
		$ctrl 	= new JControllerLegacy();
		$staff 	= $ctrl->getModel('Appointments','EasyAppointmentModel')->getStaff(); 
		$selected = $this->form->getValue('staff');

		$html[] = '<select id="'.$this->id.'" name="'.$this->name.'" class="input-sm">';
		$html[]	= '<option value="">'.JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_SELECT_STAFF').'</option>';
		$html[] = JHtml::_('select.options', $staff, 'id', 'name', $selected);
		$html[] = '</select>';

		return implode($html);
	}
	
}
?>
