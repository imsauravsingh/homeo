<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class EasyappointmentModelUser extends JModelLegacy
{
	protected $user;
	protected $service;
	protected $layout = 'profile';


	public function __construct($config = array()) 
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array();
		}
	
		parent::__construct($config);
	}


	public function getUser()
	{
		$user_id = JRequest::getVar('id',0,'','int');
		$this->user = MedialStaff::getInstance($user_id);

		if (!$this->user->isStaff())
		{
			$this->user = MedialStaff::getInstance(0);
		}
		return $this->user;
	}


	public function getService()
	{
		$service_id = JRequest::getVar('service',0,'','int');
		if ($service_id)
		{
			$this->service = $this->user->getService($service_id); 
			$this->layout = 'category';
		}
		else
		{
			$services = $this->getUser()->getServices();

			// if this staff member only has a single service selected show directly the appointment page
			if (count($services) == 1)
			{
				$this->service = $services[0];
				$this->layout = 'category';
			}
			// if not show his profile page to select one of his services
			else
			{
				$this->layout = 'profile';
				$this->service = $this->user->getService($service_id); 
			}
		}
		return $this->service;
	}
	

	public function getCalendar()
	{
		return new MedialCalendar($this->user,$this->service,7);
	}


	public function getLayout()
	{
		return $this->layout;
	}
}
?>
