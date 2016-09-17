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

class JFormFieldService extends JFormFieldList {

	public function getInput() 
	{
		$html = '<select name="'.$this->name.'" class="'.$this->element['class'].'">';	
		$html .= '<option value="0">'.JText::_('COM_EASYAPPOINTMENT_NONE').'</option>';
		$tree = MedialServices::getInstance()->getTree();
		if ($tree)
		{
			foreach ($tree as $service) 
			{
				$extra = ($this->value == $service->id) ? 'selected="selected"' : '';
				$html .= '<option value="'.$service->id.'" '.$extra.'>'. str_repeat(' - ', $service->level) . ' ' . $service->name .'</option>';
			}
		}
		$html .= '</select>';

		return $html;
	}

}
?>
