<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialAppointment extends JObject
{
	
	public $id = 0;
	public $user = 0;
	public $staff = 0;
	public $service = 0;
	public $appointmentDate = '00-00-0000';
	public $startingTime = 0;
	public $endingTime = 0;
	public $name = '';
	public $address = '';
	public $comments = '';
	public $keyring = '';
	public $published = 0;
	public $checked_out = 0;


	public function __construct()
	{
		parent::__construct();
	}


	public function bind($data) 
	{
		$this->setProperties($data);
	}


	public function insert()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$columns = array(
			$db->quoteName('id'),
			$db->quoteName('user'),
			$db->quoteName('staff'),
			$db->quoteName('service'),
			$db->quoteName('appointmentDate'),
			$db->quoteName('startingTime'),
			$db->quoteName('endingTime'),
			$db->quoteName('name'),
			$db->quoteName('email'),
			$db->quoteName('phone'),
			$db->quoteName('address'),
			$db->quoteName('comments'),
			$db->quoteName('keyring'),
			$db->quoteName('published'),
			$db->quoteName('checked_out'),
		);
		$rows = $this->id . ',' . $this->user . ',' . $this->staff . ',' . $this->service . ',' . $db->quote($this->appointmentDate) . ',' .
				$db->quote($this->startingTime) . ',' . $db->quote($this->endingTime) . ',' . $db->quote($this->name) . ',' . 
				$db->quote($this->email) . ',' . $db->quote($this->phone) . ',' . $db->quote($this->address) . ',' . $db->quote($this->comments) . ',' .
				$db->quote($this->keyring) . ',' . $this->published . ',' . $this->checked_out;
		
		$query->insert($db->quoteName('#__make_appointment_reservations'));
		$query->columns($columns);
		$query->values($rows);

		$db->setQuery($query);
		$db->query();
	}


	public function confirm($keyring,$email)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->update($db->quoteName('#__make_appointment_reservations'));
		$query->set($db->quoteName('published') . '= 1');
		$query->where($db->quoteName('keyring') . ' = ' . $db->quote($db->escape($keyring)));
		$query->where($db->quoteName('email') . ' = ' . $db->quote($db->escape($email)));

		$db->setQuery($query);
		$db->query();
	}


	public function unconfirm($keyring,$email)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->update($db->quoteName('#__make_appointment_reservations'));
		$query->set($db->quoteName('published') . '= 0');
		$query->where($db->quoteName('keyring') . ' = ' . $db->quote($db->escape($keyring)));
		$query->where($db->quoteName('email') . ' = ' . $db->quote($db->escape($email)));

		$db->setQuery($query);
		$db->query();
	}
	
	
	public function load ($id) 
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__make_appointment_reservations'));
		$query->where('id = ' . $id);
		
		$db->setQuery($query);
		$obj = $db->loadObject();
		$this->bind($obj);
	}
}
