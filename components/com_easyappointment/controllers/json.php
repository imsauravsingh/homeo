<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class EasyappointmentControllerJson extends JControllerLegacy 
{

	private $error = null;
	private $response;
	private $timeframe = 0;
	private $last;
	
	public function getSchedule()
	{
		JSession::checkToken('request') or die('Invalid Token');

		$info = JRequest::getVar('info', array(), '', 'array');
		$user_id = (int) $info['user'];
		$service_id = (int) $info['service'];
		$user = MedialStaff::getInstance($user_id);

		if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/',$info['date'],$matches))
		{	
			// first let's see if a schedule is set for the date
			$schedule = $user->getSchedule($matches[0]);
		
			// if a schedule for that certain date doesn't exist default to the schedule for the week day
			if (!$schedule->isSet)
			{
				$date = MedialStaffSchedule::getDate($matches[0]);
				$schedule = $user->getSchedule($date->__get('dayofweek'));
			}
			
			if ($schedule->working) 
			{
				// if service is also set, take schedule based on the service this user is providing
				// some services might have different timeframe
				if ($service_id)
				{
					$this->timeframe = $user->getService($service_id)->length * 60;
					$schedule->setTimeframe($this->timeframe);
				}
				$this->response = $schedule->getHours(true);
				$this->last = new stdclass;
				$this->last->value = end(array_keys($this->response)) + $this->timeframe;
				$this->last->show = MedialDisplay::showTime($this->last->value, $user->getParams()->get('hour_format'));
			}
			else 
			{
				$this->error = JText::_('COM_EASYAPPOINTMENT_ERROR_THIS_DAY_IS_FREE', true);
			}
		}
		else 
		{
			$this->error = JText::_('COM_EASYAPPOINTMENT_INVALID_DATE', true);
		}
		$this->sendResponse();
	}


	/**
	 * check if staff is available for date and time
	 */
	public function checkStaffAvailable()
	{
		JSession::checkToken('request') or die('Invalid Token');

		$info = JRequest::getVar('info', array(), '', 'array');
		$user = MedialStaff::getInstance($info['user']); 

		if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/',$info['date'],$matches))
		{	
			if(!$user->isAvailable($info))
			{
				$this->error = $user->search->getError();
			}
		}
		$this->sendResponse();
	}
	

	public function getCalendar()
	{
		JSession::checkToken('request') or die('Invalid Token');

		$info = JRequest::getVar('info', array(), '', 'array');
		JArrayHelper::toInteger($info);

		$user = MedialStaff::getInstance($info['user']);
		if (!$user->isStaff())
		{
			$this->error = 'invalid user';
		}

		if (($info['week'] + 1) > $user->getParams()->get('calendar_weeks'))
		{
			$this->error = 'invalid week';
		}
		else
		{
			$service = $user->getService($info['service']);
			$calendar = new MedialCalendar($user,$service,7,$info['week']);
			$this->response = MedialDisplay::buildCalendar($user,$service,$calendar);
		}

		$this->sendResponse();
	}

	
	// send response to browser
	protected function sendResponse()
	{
		$toreturn = new stdclass;
		$toreturn->error = $this->error;
		$toreturn->value = $this->response;
		$toreturn->timeframe = $this->timeframe;
		$toreturn->last = $this->last;

		echo json_encode($toreturn);
		exit(0);
	}

}

?>
