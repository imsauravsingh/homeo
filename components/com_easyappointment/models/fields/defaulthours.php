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

class JFormFieldDefaulthours extends JFormField
{
	public function getInput() 
	{
		$hours = array();
		$user = MedialStaff::getInstance();
		$hour_format = $user->getParams()->get('hour_format');

		for ($i=300;$i<24*3600;$i+=300)
		{
			$hours[$i] = MedialDisplay::showTime($i,$hour_format);
		}
		$html  = '<select class="' . $this->element['class'] . '" name="' . $this->name . '">';
		$html .= JHtml::_('select.options', $hours, '', '', $this->value);
		$html .= '</select>';

		return $html;
	} 
}
