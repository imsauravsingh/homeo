<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class EasyappointmentModelSchedules extends JModelLegacy
{
	public function getSpecialDays()
	{
		$schedule = MedialStaff::getInstance()->schedules;
		$schedules = (!empty($schedule)) ? unserialize($schedule) : array();
		$specials = array();

		if ($schedules)
		{
			foreach ($schedules as $key=>$obj)
			{	
				if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $key))
				{
					$specials[] = $key;
				}
			}
		}
		return $specials;
	}
}
?>
