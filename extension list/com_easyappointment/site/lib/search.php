<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialSearch
{
	private $staff;
	private $date;
	private $starthour = 0;
	private $endhour = 0;
	private $error;
	private $exclude;
    
    public function __construct(MedialStaff $user, $options)
    {	
    	if ($user && $options['date']) 
    	{
    		foreach ($options as $key=>$value)
    		{
    			$this->{$key} = $value;
    		}
    		$this->staff = $user;
    	}
    	else 
    	{
    		throw new Exception('Error initializing search');
    	}
    	
    	if(isset($options['exclude']))
    	{
    		$this->exclude = $options['exclude'];
    	}
	}


	public function getAvailability()
	{
		if (!$this->isStaffFree())
		{
			$this->error = JText::_('COM_EASYAPPOINTMENT_ERROR_STAFF_NOT_AVAILABLE_FOR', true);
			return false;
		}
		return true;
	}

	
	public function getError()
	{
		return $this->error;
	}


	/**
	 *
	 * check if any the staff member has any other reservation in selected interval
	 * 
	 * @return boolean  true if the staff member is available, false if the staff member is not available
	 */
	protected function isStaffFree()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__make_appointment_reservations');
		$query->where('(
						(endingTime > ' . $this->starthour . ' AND endingTime <= ' . $this->endhour . ') OR 
						(startingTime >= ' . $this->starthour . ' AND startingTime < ' . $this->endhour . ') OR
						(startingTime <= ' . $this->starthour . ' AND endingTime >= ' . $this->endhour . ')
						)');
		$query->where('staff = ' . $this->staff->id);
		$query->where('appointmentDate = '. $db->quote($db->escape($this->date)));
		if ($this->exclude)
		{
			$query->where('id !=' . $this->exclude);
		}
	
		$db->setQuery($query);
		$rez = $db->loadResult();
		return $rez ? false : true;		
	}


	// get user busy hours for this day
	public function getUserBusyHours()
	{
		$busy = array();
		$bookings = $this->getUserBookings();

		if ($bookings)
		{
			foreach ($bookings as $booking)
			{
				for ($i = $booking->startingTime; $i < $booking->endingTime; $i += 300)
				{
					$busy[] = $i;
				}
			}
		}

		return $busy;
	}


	protected function getUserBookings()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('startingTime, endingTime');
		$query->from('#__make_appointment_reservations');
		$query->where('staff = ' . $this->staff->id);
		$query->where('appointmentDate = ' . $db->quote($this->date));
		
		$db->setQuery($query);
		return $db->loadObjectList();
	}

}

?>
