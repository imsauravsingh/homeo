<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialStaff extends JUser
{
	private static $instance;
	private static $schedule;
	public $search;
	public $description;
	public $picture;


    public static function getInstance($identifier = 1, JUserWrapperHelper $userHelper = NULL)
    {
	    if ($identifier == 1)
		{
			$identifier = JFactory::getUser()->get('id');
		}

    	if (!isset(self::$instance[$identifier]))
    	{
    		self::$instance[$identifier] = new MedialStaff($identifier);
    	}
    	return self::$instance[$identifier];
    }


    public function __construct($identifier)
    {
    	parent::__construct($identifier);
    	$record = $this->_loadStaff($this->id);
		$this->setProperties($record);
    }

	/*
	 * Get staff user settings
	 *
	 * return a staff param object
	 */
	public function getParams()
	{
		$params = new MedialStaffParams($this->params);

		return $params;
	}


	/*
	 * Get services that this staff member can execute
	 *
	 * return	array of service object
	 */
	public function getServices()
	{
		$services = array();

		if (!empty($this->services))
		{
			$ids = json_decode($this->services);
			foreach ($ids as $value)
			{
				$services[] = $this->getService($value);
			}
		}

		return $services;
	}


	/**
	 * get a single service object
	 * this will override service price and length to fit the user preferences
	 *
	 * @param [int] $serviceid 		ID for the service to return
	 *
	 * @return [object] [an instance of service]
	 */
	public function getService($serviceid)
	{
		$service = MedialService::getInstance($serviceid);
		$params = $this->getParams();

		// set custom price if set
		if ($params->get('prices'))
		{
			$prices = $params->get('prices');
			if (isset($prices->$serviceid))
			{
				$service->price = $prices->$serviceid;
			}
		}

		// set custom length
		if (empty($serviceid))
		{
			$service->length = $params->get('timeframe');
		}
		else
		{
			if ($params->get('service_length'))
			{
				$length = $params->get('service_length');
				if (isset($length->$serviceid))
				{
					$service->length = $length->$serviceid;
				}
			}
		}

		return $service;
	}


	/**
	 * return schedule for a date/weekday
	 * @param  [mixed] $day [integer - weekday, string - date in formay YYYY-mm-dd]
	 * @return 	object 		schedule object container
	 */
	public function getSchedule($day = 0)
	{
		if(!isset(self::$schedule[$day]))
		{
			self::$schedule[$day] = new MedialStaffSchedule($this,$day);
		}
		return self::$schedule[$day];
	}


	/*
	 * Check if logged in user is part of staff
	 *
	 * return boolean	true if logged in user is part of staff, false if not
	 */
	public function isStaff()
	{
		if ($this->id && isset($this->user) && $this->published)
		{
			return ($this->id == $this->user);
		}
		return false;
	}


	/**
	 * check if staff member is available for reservations at $date and for time interval from $start to $end
	 *
	 * @param array $options 	(keys: date => (string YYYY-mm-dd) , start => (int) starting time, end => (int) ending time, exclude => optionaly (int) reservation ID)
	 *
	 * return boolean
	 */
	public function isAvailable($options)
	{
		$this->search = new MedialSearch($this, $options);
		$isAvailable = $this->search->getAvailability();
		return $isAvailable;
	}


	/**
	 * store staff properties (params, services, description, schedules)
	 *
	 * @param [string] $key 		name of table field where to store
	 * @param [string] $value 		new value for table field
	 */
	public function store($key,$value)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update($db->quoteName('#__make_appointment_staff'));
		$query->set($db->quoteName($key) . ' = ' . $db->quote($value));
		$query->where($db->quoteName('id') . ' = ' . $this->id);

		$db->setQuery($query);
		$db->query();
	}


	/**
	 * send notification to client when a new appointment is done
	 *
	 * @param [object] [$app] [MedialAppointment object]
	 */
	public function sendNotification($app)
	{
		$send = $this->getParams()->get('send_email');
		$from_email = $this->getParams()->get('send_email_from');
		$subject = $this->getParams()->get('send_email_subject');
		$body = $this->getParams()->get('send_email_body');

		if ($send && $from_email && $subject && $body)
		{
			$confirmation = new MedialConfirmation($this,$app);
			$confirmation->setSubject($subject);
			$confirmation->setBody($body);
			$confirmation->setFromEmail($from_email);
			$confirmation->setFromName($this->name);
			$confirmation->setToEmail($app->email);

			$confirmation->send();
		}
	}


	/**
	 * receive notification when new appointment
	 *
	 * @param [object] [$app] [MedialAppointment object]
	 */
	public function receiveNotification($app)
	{
		$receive = $this->getParams()->get('receive_email');
		$to_email = $this->getParams()->get('receive_email_to');
		$subject = $this->getParams()->get('receive_email_subject');
		$body = $this->getParams()->get('receive_email_body');

		if ($receive && $to_email && $subject && $body)
		{
			$confirmation = new MedialConfirmation($this,$app);
			$confirmation->setSubject($subject);
			$confirmation->setBody($body);
			$confirmation->setFromEmail($app->email);
			$confirmation->setFromName($app->name);
			$confirmation->setToEmail($to_email);

			$confirmation->send();
		}
	}


	/*
	 * Get stored data from staff table for a certain user
	 * @param	int $id		User ID
	 *
	 * return 	object
	 */
	private function _loadStaff($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__make_appointment_staff'));
		$query->where($db->quoteName('user') . ' = ' . (int) $id);

		$db->setQuery($query);
		return $db->loadObject();
	}

}
?>
