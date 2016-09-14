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

class EasyappointmentModelSpecial extends JModelAdmin
{

	protected $text_prefix = '';


	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_easyappointment.special', 'special', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}

	protected function loadFormData()
	{
		$data = $this->getSpecial();
		return $data;
	}

	public function getSpecial()
	{
		$date = JRequest::getVar('date');
		$special = new stdclass;
		$special->intervals = array();
		$special->date = null;
		$special->status = 1;

		if ($date)
		{
			$schedule = MedialStaff::getInstance()->getSchedule($date); 
			$special->status = $schedule->working;
			$special->date = $date;
			$special->intervals = $schedule->getIntervals();
		}
		
		return $special;
	}


	
}
?>
