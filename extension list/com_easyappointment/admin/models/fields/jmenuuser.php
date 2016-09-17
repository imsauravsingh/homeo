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

class JFormFieldJmenuuser extends JFormFieldList {

	public function getInput() {
		
		$html 	= array();
		$ctrl 	= new JControllerLegacy();
		$staff 	= $this->getStaff();

		$html[] = '<select id="'.$this->id.'" name="'.$this->name.'" class="input-sm">';
		$html[]	= '<option value="">'.JText::_('COM_EASYAPPOINTMENT_STAFF_SELECT').'</option>';
		$html[] = JHtml::_('select.options', $staff, 'id', 'name', $this->value);
		$html[] = '</select>';

		return implode($html);
	}
	

	protected function getStaff() 
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery( true );
		$query->select('a.id, a.name');
		$query->from('#__make_appointment_staff AS a');
		$db->setQuery ( $query );
		return $db->loadObjectList();
	}

}
?>
