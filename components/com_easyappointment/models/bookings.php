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

class EasyappointmentModelBookings extends JModelList
{
	protected $user;
	
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array();
		}
		$this->user = MedialStaff::getInstance();
		parent::__construct($config);
	}
	
	
	protected function populateState($ordering = null, $direction = null) { 
		
		// Initialise variables.
		$app = JFactory::getApplication();

		$datephp = $app->getUserStateFromRequest($this->context.'.filter.bookings.datephp', 'filter_bookings_datephp', '', 'string');
		$this->setState('filter.bookings.datephp', $datephp);

		$state = $app->getUserStateFromRequest($this->context.'.filter.bookings.status', 'filter_status', -1, '');
		$this->setState('filter.bookings.status', $state);
		
		$state = $app->getUserStateFromRequest($this->context.'.filter.bookings.service', 'filter_service', null, 'int');
		$this->setState('filter.bookings.service', $state);

		// List state information.
		parent::populateState('a.id', 'desc');
	}
	
	protected function getStoreId($id = '') {
		
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.bookings.status');
		$id	.= ':'.$this->getState('filter.bookings.datephp');
		$id	.= ':'.$this->getState('filter.bookings.service');

		return parent::getStoreId($id);
	}
	
	

	protected function getListQuery() 
	{
		$query = $this->_db->getQuery(true);

		$query->select( $this->_db->quoteName('id') . ',' .
						$this->_db->quoteName('service') . ',' .
						$this->_db->quoteName('appointmentDate') . ',' .
						$this->_db->quoteName('startingTime') . ',' . 
						$this->_db->quoteName('endingTime') .',' .
						$this->_db->quoteName('name') . ',' . 
						$this->_db->quoteName('published') );
		$query->from($this->_db->quoteName('#__make_appointment_reservations'));

		// filter by selected date
		$date = $this->getState('filter.bookings.datephp', null); 
		if ($date) 
		{
			$query->where($this->_db->quoteName('appointmentDate') . ' = ' . $this->_db->quote($this->_db->escape($date)));
		} 
		
		// filter by status
		$status = $this->getState('filter.bookings.status', -1); 
		if ($status != -1)
		{
			$query->where($this->_db->quoteName('published') . ' = ' . (int) $status);
		}
		
		// filter by service
		$service = $this->getState('filter.bookings.service',0);
		if ($service)
		{
			$query->where($this->_db->quoteName('service') . ' = ' . (int) $service);
		}
		
		$query->where($this->_db->quoteName('staff') . ' = ' . $this->user->get('id'));
		return $query;
	}


	/**
	 *  get export object containing details like filetype, mime and name
	 */
	public function getExport()
	{
		$exported = new stdclass;
		$export_as = $this->user->getParams()->get('booking_export_type');
		
		if (!$export_as) 
		{
			$exported->mimetype = 'text/csv';
			$exported->filetype = 'csv';
		}
		elseif ($export_as == 1)
		{
			$exported->mimetype = 'text/calendar';
			$exported->filetype = 'ics';
		}
		
		$exported->basename = JText::_('COM_EASYAPPOINTMENT_BOOKINGS') . '_' . date('Y-m-d',time());

		return $exported;
	}


	/**
	 * retrieve content to put inside the exported file
	 * @return [string] 
	 */
	public function getExportContent()
	{
		$export_as = $this->user->getParams()->get('booking_export_type');
		if (!$export_as) 
		{
			$content = $this->getCsv();
		}
		elseif ($export_as == 1)
		{
			$content = $this->getIcal();
		}
		return $content;
	}


	public function getCSV()
	{
		if (!isset($this->content)) {

			$this->content = '';
			$this->content.=
			'"'.str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_CLIENT')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_DATE')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_FROM_HOUR')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_TO_HOUR')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_SERVICE')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_BOOKINGS_STATUS')).'"' . "\n";

			foreach($this->getItems() as $item) {
				
				$date = MedialDisplay::showDate($item->appointmentDate,$this->user->getParams()->get('date_format'));
				$from = MedialDisplay::showTime($item->startingTime,$this->user->getParams()->get('hour_format'));
				$to = MedialDisplay::showTime($item->endingTime,$this->user->getParams()->get('hour_format'));
				$service = MedialService::getInstance($item->service);
				$status = $item->published ? JText::_('COM_EASYAPPOINTMENT_CONFIRMED') : JText::_('COM_EASYAPPOINTMENT_UNCONFIRMED');

				$this->content.=
				'"'.str_replace('"', '""', $item->name).'","'.
					str_replace('"', '""', $date).'","'.
					str_replace('"', '""', $from).'","'.
					str_replace('"', '""', $to).'","'.
					str_replace('"', '""', $service->name).'","'.
					str_replace('"', '""', $status).'"' . "\n";
			}
		}
		return $this->content;
	}
	
	
	public function getIcal()
	{
		if (!isset($this->content)) 
		{
			$this->content = 'BEGIN:VCALENDAR' . "\n";
			$this->content .= 'VERSION:2.0' . "\n";
			$this->content .= 'PRODID:' . sha1(time()) ."\n";
			
			foreach($this->getItems() as $item) 
			{
				$from = MedialDisplay::showTime($item->startingTime,$this->user->getParams()->get('hour_format'));
				$to = MedialDisplay::showTime($item->endingTime,$this->user->getParams()->get('hour_format'));
				$status = $item->published ? JText::_('COM_EASYAPPOINTMENT_CONFIRMED') : JText::_('COM_EASYAPPOINTMENT_UNCONFIRMED');
				$service = MedialService::getInstance($item->service);
				$dtstart = str_replace('-','',$item->appointmentDate) . 'T' . str_replace(':','',MedialDisplay::showTime($item->startingTime,24)) . '00';
				$dtend = str_replace('-','',$item->appointmentDate) . 'T' . str_replace(':','',MedialDisplay::showTime($item->endingTime,24)) . '00';
				$description = sprintf(JText::_('COM_EASYAPPOINTMENT_RESERVATION_FOR_WITH'), $service->name, $item->name, $status);
				
				$this->content .= 'BEGIN:VEVENT' . "\n";
				$this->content .= 'DTSTART:' . $dtstart .  "\n";
				$this->content .= 'DTEND:' . $dtend . "\n";
				$this->content .= 'SUMMARY:' . $description . "\n";
				$this->content .= 'DESCRIPTION:' . $description . "\n";
				$this->content .= 'END:VEVENT' . "\n";
			}
			$this->content .= 'END:VCALENDAR';
		}
		return $this->content;
	}
	
	
	public function getUser()
	{
		return $this->user;
	}

}
?>
