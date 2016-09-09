<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');

class EasyappointmentModelFinish extends JModelLegacy
{
	protected $text_prefix = 'COM_EASYAPPOINTMENT';
	protected $default_data;

	public function __construct()
	{
		$this->default_data = array('staff'=>0,'service'=>0,'appointmentDate'=>'0000-01-01', 'startingTime'=>0, 'email'=>'');
		parent::__construct();
	}


	public function getReservationItem()
	{
		$data = JFactory::getApplication()->getUserState('com_easyappointment.finish.data', $this->default_data);
		return $data;
	}


	public function getUser()
	{
		$data = $this->getReservationItem();
		return MedialStaff::getInstance($data['staff']);
	}


	public function getService()
	{
		$data = $this->getReservationItem();
		return MedialService::getInstance($data['service']);
	}
	
}
?>
