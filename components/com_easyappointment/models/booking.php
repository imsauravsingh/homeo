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

class EasyappointmentModelBooking extends JModelAdmin
{

	protected $text_prefix = 'COM_EASYAPPOINTMENT';

	public function getTable($type = 'Appointments', $prefix = 'EasyappointmentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.booking', 'booking', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		
		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.booking.data', array());
		
		if (empty($data)) {
			$data = $this->getItem();
		}
		
		return $data;
	}

	protected function populateState() 
	{ 	 
		parent::populateState();
	}

	
	public function verify($data)
	{
		// check if selected date is not in the past
		$tz = new DateTimeZone(JFactory::getApplication()->getCfg('offset'));
        $now = JFactory::getDate('now',$tz);
        $user = MedialStaff::getInstance($data['staff']);
        $rez = true;

        if (MedialDisplay::strToTime($data['appointmentDate']) < MedialDisplay::strToTime($now->format('Y-m-d', true)))
        {
			$this->setError(JText::_('COM_EASYAPPOINTMENT_ERROR_DATE_IN_PAST'));
			$rez = false;
		}

		// check if selected end hour is not smaller than selected start hour
		if ($data['startingTime'] >= $data['endingTime'])
		{
			$this->setError(JText::_('COM_EASYAPPOINTMENT_ERROR_START_END_HOURS'));
			$rez = false;
		}

		// check if staff is available for this date and this interval
		$options = array('date'=>$data['appointmentDate'], 'start'=>$data['startingTime'], 'end'=>$data['endingTime']);
		if (!$user->isAvailable($options))
		{
			$rez = false;
			$this->setError($user->search->getError());
		}
	
		return $rez;
	}


	/*
	 * clean data before saving
	 * 
	 * @params [array] $data		form data
	 * @return [array] $data		filtered data
	 */
	public function cleanData($data)
	{
		$regexs = array(
				'service'=>'/^[0-9]{1,}$/',
				'appointmentDate' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',
				'startingTime' => '/^[0-9]{1,}$/',
				'endingTime' => '/^[0-9]{1,}$/',
				'email' => '/^[A-Za-z0-9-\._]{1,}@[\w-\.]*\.[\w]{2,}$/',
				'phone' => '/[\w\s.\-()+]*/',
				);

		foreach ($data as $key => $value)
		{
			if(isset($regexs[$key]))
			{
				preg_match($regexs[$key],$value,$matches);
				$data[$key] = isset($matches[0]) ? $matches[0] : '';
			}
			else
			{
				$data[$key] = JFilterInput::getInstance()->clean($data[$key],'string');
			}
		}

		return $data;
	}
	
}
?>
