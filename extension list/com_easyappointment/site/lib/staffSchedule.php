<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.utilities.date');

class MedialStaffSchedule{

	protected $staff;
	protected $timeframe;
	protected $intervals = array();
	protected $date;
	protected static $hours;
	protected static $default_hours;
	public $working = true;
	public $isSet = false;


	public function __construct($user, $day)
	{
		$this->staff = $user;
		if ($day)
		{
			$this->_for($day);
		}
	}


    /**
     * specify the date/day of week
     */
    protected function _for($input)
    {	
    	$this->date = $input;
    	$encoded = !empty($this->staff->schedules) ? unserialize($this->staff->schedules) : array();

		if(isset($encoded[$this->date]))
		{
			$this->isSet = true;
			$this->working = isset($encoded[$this->date]->working) ? $encoded[$this->date]->working : 1;
			$this->intervals = isset($encoded[$this->date]->intervals) ? $encoded[$this->date]->intervals : array();			
		} 
    }



	/**
	 * get all available hours for the day
	 * @return [array] 
	 */
	public function getHours( $translated = false )
	{	
	
		$timeframe = $this->getTimeframe();
		$hours = array();
		$format = $this->staff->getParams()->get('hour_format');

		if ($this->working)
		{	
			foreach( $this->intervals as $key=>$interval )
			{
				for($i=$interval['start'];$i<=$interval['end'];$i+=$timeframe)
				{
					$hours[0][$i] = $i;
					$hours[1][$i] = MedialDisplay::showTime($i, $format);
				}
			}
		}

		if (empty($hours[0]))
		{
			self::$hours[0] = $this->getDefaultHours(false);
			self::$hours[1] = $this->getDefaultHours(true);
		}
		else
		{
			self::$hours[0] = $hours[0];
			self::$hours[1] = $hours[1];
		}
		
		return $translated ? self::$hours[1] : self::$hours[0];
	}


	/**
	 * return the schedule end hour
	 */
	public function getMax($translated = false)
	{
		$hours = $this->getHours(false);
		$max = max($hours);
		return $translated ?  MedialDisplay::showTime($max, $this->staff->getParams()->get('hour_format')) : $max;
	}


	/**
	 * return the schedule start hour
	 */
	public function getMin($translated = false)
	{
		$hours = $this->getHours(false);
		$min = min($hours);
		return $translated ?  MedialDisplay::showTime($min, $this->staff->getParams()->get('hour_format')) : $min;
	}


	public function getIntervals()
	{
		return $this->intervals;
	}
	

	/**
	 *
	 * return default hours in case no schedule is set for that date/day of week
	 * start with opening hour for restaurant and end with closing hour of restaurant
	 * 
	 * @return [type] [description]
	 */
 	public function getDefaultHours($translated = true)
    {   
    	$v = $translated ? 1 : 0;
    	$timeframe = $this->getTimeframe();

      	if(!isset(self::$default_hours[$v]))
      	{
      		$starthour = $this->staff->getParams()->get('starthour');
      		$endhour =  $this->staff->getParams()->get('endhour');
      		$hour_format =  $this->staff->getParams()->get('hour_format');
   
	        for ($i = $starthour; $i <= $endhour; $i += $timeframe)
	        {
	        	self::$default_hours[0][$i] = $i;
	        	self::$default_hours[1][$i] = MedialDisplay::showTime($i, $hour_format);
	        }
      	}
        return self::$default_hours[$v];
    }

 

	/**
	 * get a datetime object depending on the website offset
	 * @return [integer]
	 */
	public static function getDate( $timestamp )
	{
		//$tz = new DateTimeZone(JFactory::getApplication()->getCfg('offset'));
		$now = JFactory::getDate($timestamp);
		//$now->setTimeZone($tz);

		return $now;
	}


	/**
	 * set time frame between time nodes
	 */
	public function setTimeframe($seconds)
	{
		$this->timeframe = $seconds;
	}


	protected function getTimeframe()
	{
		if (empty($this->timeframe))
		{
			$this->timeframe = $this->staff->getParams()->get('timeframe');
		}
		return $this->timeframe;
	}
}
