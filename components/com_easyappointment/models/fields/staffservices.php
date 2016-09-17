<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldStaffServices extends JFormField
{

	public function getInput() 
	{
		$user = MedialStaff::getInstance();
		$services = $user->getServices();
		$html = '';
		
		if ($services) 
		{
			$html .= '<select name="'.$this->name.'" id="'.$this->id.'" class="'.$this->element['class'].'">';
			$html .= JHtml::_('select.options', $services, 'id', 'name', $this->value);
			$html .= '</select>';
		}

		return $html;
	} 
	
}
