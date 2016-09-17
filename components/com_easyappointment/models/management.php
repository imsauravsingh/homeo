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
jimport('joomla.utilities.date');

class EasyappointmentModelManagement extends JModelList
{
	protected $user;

	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array();
		}
		$this->user = MedialStaff::getInstance();
		parent::__construct($config);
	}


	public function getTodayBookings()
	{
		$today = JFactory::getDate('now')->format('Y-m-d');

		$query = $this->_db->getQuery(true);
		$query->select(	$this->_db->quoteName('id') . ',' .
						$this->_db->quoteName('name') .',' .
						$this->_db->quoteName('service') . ',' .
						$this->_db->quoteName('startingTime') . ',' .
						$this->_db->quoteName('endingTime') . ',' .
						$this->_db->quoteName('name') );
		$query->from($this->_db->quoteName('#__make_appointment_reservations'));
		$query->where($this->_db->quoteName('staff') . ' = ' . $this->user->get('id'));
		$query->where($this->_db->quoteName('appointmentDate') . ' = ' . $this->_db->quote($today));
		$query->where($this->_db->quoteName('published') . ' = 1');
		$query->order('startingTime ASC');

		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}


	public function getUser()
	{
		return $this->user;
	}


}
?>
