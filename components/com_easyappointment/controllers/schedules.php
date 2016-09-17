<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class EasyappointmentControllerSchedules extends JControllerLegacy {


	/**
	 * add a new recording for a specified day 
	 * @return [string] html formated with the new recording to display in the schedule table
	 */
	public function newRow() 
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));	
		$toAdd = JRequest::getVar('info', array(), '', 'array');
		$response = new stdclass;

		if ($toAdd)
		{
			$schedule = MedialStaff::getInstance()->schedules;

			if ( !$schedule ) 
			{
				$record = new stdclass;
				$record->working = 1;
				$record->intervals[] = $toAdd;
				$records[$toAdd['id']] = $record;
				$row = serialize($records);
			}
			else 
			{
				$records = unserialize($schedule);
				if(!isset($records[$toAdd['id']]))
				{
					$records[$toAdd['id']] = new stdclass;
					$records[$toAdd['id']]->working = 1;
				}
				$records[$toAdd['id']]->intervals[] = $toAdd;
				$row = serialize($records);
			}

			MedialStaff::getInstance()->store('schedules', $row);
			$response->start = MedialDisplay::showTime($toAdd['start'],MedialStaff::getInstance()->getParams()->get('hour_format'));
			$response->end = MedialDisplay::showTime($toAdd['end'],MedialStaff::getInstance()->getParams()->get('hour_format'));
		}
	
		echo json_encode($response);
		exit(0);
	}



	/**
	 *
	 * change the status for a day 0 if it's a non working day, 1 if it's a working day
	 */
	public function changeDayStatus()
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));	

		$data = JRequest::getVar('info', array(), '', 'array');
		$schedule = MedialStaff::getInstance()->schedules;
		$response = new stdclass;
		$new_schedule = null;

		if (!$schedule) 
		{
			$records[$data['id']] = new stdclass;
			$records[$data['id']]->working = $data['status'];
		}
		else 
		{
			$records = unserialize($schedule);
			if(!isset($records[$data['id']]))
			{
				$records[$data['id']] = new stdclass;
			}
			$records[$data['id']]->working = $data['status'];
			$new_schedule = serialize($records);
		}

		$response->status = $data['status'] ? JText::_('COM_EASYAPPOINTMENT_WORKING_DAY', true) : JText::_('COM_EASYAPPOINTMENT_FREE_DAY', true);
		$response->button = $data['status'] ? JText::_('COM_EASYAPPOINTMENT_TOOGLE_DAY_STATE_0', true) : JText::_('COM_EASYAPPOINTMENT_TOOGLE_DAY_STATE_1', true);
		$new_schedule = serialize($records);
		MedialStaff::getInstance()->store('schedules', $new_schedule);
		
		echo json_encode($response);
		exit(0);
	}



	/**
	 * delete a certain interval from a day schedule
	 * @return 1
	 */
	public function deleteInterval()
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));	
		$data = JRequest::getVar('info', array(), '', 'array');

		$schedule = MedialStaff::getInstance()->schedules;

		if ( $schedule ) 
		{
			$records = unserialize($schedule);
			// if we have a schedule for that day, and exist intervals in the schedule search for the interval that fit the requirements
			if(isset($records[$data['id']]) && isset($records[$data['id']]->intervals))
			{
				foreach ( $records[$data['id']]->intervals as $key=>$interval )
				{
					if ( $interval['id'] == $data['id'] && $interval['start'] = $data['start'] && $interval['end'] == $data['end'] )
					{
						unset($records[$data['id']]->intervals[$key]);
					}
				}
			}
			$new_schedule = serialize($records);
			MedialStaff::getInstance()->store('schedules', $new_schedule);
		}

		echo 1;
		exit(0);
	}


	/**
	 * delete a special day schedule from the restaurant schedule
	 * @return 1
	 */
	public function delSpecialDay() 
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));	

		$data = JRequest::getVar('info', array(), '', 'array');
		$schedule = MedialStaff::getInstance()->schedules;
		$new_schedule = null;

		if ($schedule) 
		{
			$records = unserialize($schedule);
			if(isset($records[$data['date']]))
			{
				unset($records[$data['date']]);
			}
			$new_schedule = serialize($records);
			MedialStaff::getInstance()->store('schedules', $new_schedule);
		}
		echo 1;
		exit(0);
	}

}

?>
