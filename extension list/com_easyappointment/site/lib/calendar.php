<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialCalendar
{
	public $user;
	public $service;
	public $length;
	public $max_count_hours = 0;
	public $timeframe;
	private $days;
	private $startweek;
	

	public function __construct ($user, $service, $length = 7, $startweek = 0)
	{
		$this->user = $user;
		$this->service = $service;
		$this->length = $length;
		$this->startweek = $startweek;
		$this->timeframe = $this->getTimeframe();
		$this->initDays();
	}


	public function getDays()
	{
		$this->setStartDay();
		$this->getDaysNames();
		$this->getDaysDates();
		$this->getDaysHours();
		$this->getBusyHours();
		  
		return $this->days;
	}


	public function getTimeframe()
	{
		return $this->user->getService($this->service->id)->length * 60;
	}


	protected function getDaysNames()
	{
		$weekdays = MedialDisplay::showWeekDays('phpcalendar');
		$start = $this->start->__get('dayofweek');
		for ($i=0;$i<$this->length;$i++)
		{
			$key = ($start+$i) % 7;
			$this->days[$i]->name = $weekdays[$key];
			$this->days[$i]->dayofweek = $key;
		}	
	}


	protected function getDaysDates()
	{
		$day = $this->start->__get('day');
		$month = $this->start->__get('month');
		$year = $this->start->__get('year');

		date_default_timezone_set('UTC');

		for ($i=0;$i<$this->length;$i++)
		{
			$this->days[$i]->date = date('Y-m-d', mktime(0, 0, 0, $month, ($day+$i), $year));
		}	
	}


	protected function getDaysHours()
	{
		foreach ($this->days as $key=>$day)
		{
			// first let's see if a schedule is set for the date
			$schedule = $this->user->getSchedule($day->date);
		
			// if a schedule for that certain date doesn't exist default to the schedule for the week day
			if (!$schedule->isSet)
			{
				$dayofweek = $day->dayofweek == 0 ? 7 : $day->dayofweek;
				$schedule = $this->user->getSchedule($dayofweek);
			}

			// set time frame to the service length
			$schedule->setTimeframe($this->timeframe);

			// get hours
			$this->days[$key]->hours = $schedule->getHours(true);
			$this->days[$key]->working = $schedule->working;

			$nr_hours = $schedule->working ? count($this->days[$key]->hours) : 0;
			$this->max_count_hours = $this->max_count_hours > $nr_hours ? $this->max_count_hours : $nr_hours;
		}
	}


	protected function getBusyHours()
	{
		foreach ($this->days as $key=>$day)
		{
			$search = $this->getSearch($day->date);
			$this->days[$key]->busy = $search->getUserBusyHours();
		}
	}


	// return a search object for $date
	protected function getSearch($date)
	{
		return new MedialSearch($this->user, array('date'=>$date));
	}


	protected function initDays()
	{
		for ($i=0;$i<$this->length;$i++)
		{
			$this->days[$i] = new stdclass;
		}
	}


	/**
	 * set start day for the calendar
	 */
	protected function setStartDay()
	{
		$now = JFactory::getDate('now');
		$day = $now->__get('day');
		$month = $now->__get('month');
		$year = $now->__get('year');
		$offset = $this->startweek * $this->length;

		date_default_timezone_set('UTC');
		$start = date('Y-m-d', mktime(0, 0, 0, $month, ($day+$offset), $year));

		$this->start = JFactory::getDate($start);
	}


}
?>
