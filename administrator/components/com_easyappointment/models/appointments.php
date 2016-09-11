<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class EasyappointmentModelAppointments extends JModelList
{	
	protected $helper;
	protected $export;

	public function __construct($config = array()) {

		$this->export = JFactory::getApplication()->getUserState('export.details', array());
		parent::__construct($config);
	}
	
	protected function populateState( $ordering = null, $direction = null ) { 
		
		// Initialise variables.
		$app = JFactory::getApplication('administrator');
		
		$state = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search', '', 'string');
		$this->setState('filter.search', $state);
		
		$state = $app->getUserStateFromRequest($this->context.'.filter.staff', 'filter_staff', '', 'int');
		$this->setState('filter.staff', $state);

		$state = $app->getUserStateFromRequest($this->context.'.filter.service', 'filter_service', '', 'int');
		$this->setState('filter.service', $state);

		$state = $app->getUserStateFromRequest($this->context.'.filter.status', 'filter_status', '', 'string');
		$this->setState('filter.status', $state);

		$state = $app->getUserStateFromRequest($this->context.'.filter.date', 'filter_date', '', 'string');
		$this->setState('filter.date', $state);

		parent::populateState('a.id', 'desc');
	}
	
	
	protected function getStoreId($id = '') {

		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.staff');
		$id	.= ':'.$this->getState('filter.service');
		$id	.= ':'.$this->getState('filter.status');
		$id	.= ':'.$this->getState('filter.date');

		return parent::getStoreId($id);
	}
	

	protected function getListQuery() {
		
		// Create a new query object.
		$query	= $this->_db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select','a.id, a.appointmentDate, a.startingTime, a.endingTime, a.name, a.email, a.published, b.name AS service, c.name AS staffname, a.staff, d.id AS status, a.keyring'
			)
		);
		$query->from(' #__make_appointment_reservations AS a ');
		$query->join('left', '#__make_appointment_services AS b ON a.service = b.id');
		$query->join('left', '#__make_appointment_staff AS c ON a.staff = c.id');
		$query->join('left', '#__make_appointment_payments AS d ON a.keyring = d.keyring');

		// Filter by status
		$status = $this->getState('filter.status');
		if ( $status != ''  ) {
			$query->where( 'a.published = ' . (int) $status );
		}

		// Filter by staff
		$staff = $this->getState('filter.staff');
		if ( !empty( $staff )) {
			$query->where( 'a.staff = ' . (int) $staff );
		}

		// filter by service
		$service = $this->getState('filter.service');
		if ( !empty( $service )) {
			$query->where( 'a.service = ' . (int) $service );
		}

		// filter by date
		$date = $this->getState('filter.date');
		if ( !empty($date) ) {
			$query->where('a.appointmentDate = ' . $this->_db->quote($date));
		}

		// Filter by search (customer name, email)
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else
			{
				$search = $this->_db->Quote('%'.$this->_db->escape(strtolower($search), true).'%');
				$query->where('( LOWER(a.name) LIKE '.$search.' OR LOWER(a.email) LIKE '.$search.')');
			}
		}
		
		// Add the list ordering clause.
		$orderCol = $this->getState('list.ordering', 'a.id');
		$query->order($this->_db->escape($orderCol).' '.$this->_db->escape($this->getState('list.direction', 'DESC')));

		return $query;
	}
	
	
	public function getStaff() {
		$query = $this->_db->getQuery( true );
		$query->select('a.id, a.name');
		$query->from('#__make_appointment_staff AS a');
		$this->_db->setQuery ( $query );
		return $this->_db->loadObjectList();
	}


	public function getServices() {
		$query = $this->_db->getQuery( true );
		$query->select('a.id, a.name');
		$query->from('#__make_appointment_services AS a');
		$query->order('parent ASC');
		$this->_db->setQuery ( $query );
		return $this->_db->loadObjectList();
	}


	// function used to get a name for the exported archive
	public function getBasename() {

		return $this->export['basename'] ? $this->export['basename'] : time(); 
	}

	
	public function getFileType()
	{
		return $this->export['format'];
	}


	public function getMimeType()
	{
		if ( $this->export['format'] == 'csv' )
		{
			return 'text/csv';
		} 
		elseif ( $this->export['format'] == 'ics' ) 
		{
			return 'text/calendar';
		}
	}


	public function getExport() 
	{

		if ( $this->export['format'] == 'csv' )
		{
			return $this->getCsv();
		} 
		elseif ( $this->export['format'] == 'ics' ) 
		{
			return $this->getIcs();
		}
	}


	public function getFileLocation() {

		$name = $this->getBasename()  . '.' . $this->getFileType();
		$location = JFactory::getConfig()->get('tmp_path') . DIRECTORY_SEPARATOR .  $name;
	
		$content = $this->getExport();

		JFile::write( $location, $content );
		return $location;
	}


	protected function getCsv() 
	{
		if (!isset($this->content)) {

			$this->content = '';
			$this->content.=
			'"'.str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_APP_NUMBER')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_APP_DATE')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_APP_START')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_CLIENT_NAME')).'","'.
				str_replace('"', '""', JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_STATUS')).'"' . "\n";

			foreach($this->getItems() as $item) {

				$code 	= $item->keyring;
				$date 	= $item->appointmentDate;
				$start 	= MedialDisplay::showTime($item->startingTime);
				$status = $item->published ? 
						JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_CONFIRMED') : JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_UNCONFIRMED');

				$this->content.=
				'"'.str_replace('"', '""', $code).'","'.
					str_replace('"', '""', $date).'","'.
					str_replace('"', '""', $start).'","'.
					str_replace('"', '""', $item->name).'","'.
					str_replace('"', '""', $status).'"' . "\n";
			}
		}
		return $this->content;
	}


	protected function getIcs() 
	{
		if (!isset($this->content)) {

			$tz = JFactory::getApplication()->getCfg('offset');

			$this->content = '';
			$this->content.= "BEGIN:VCALENDAR\n";
			$this->content.= "VERSION:2.0\n";
			$this->content.= "CALSCALE:GREGORIAN\n";
			$this->content.= "METHOD:PUBLISH\n";
			$this->content.= "X-WR-CALNAME:EasyAppointment\n";
			$this->content.= "X-WR-RELCALID:EasyAppointment\n";
			$this->content.= "X-WR-TIMEZONE:$tz\n";
			$this->content.= "X-WR-CALDESC:EasyAppointment Calendar\n";

			foreach($this->getItems() as $item) 
			{	
				$start = $item->appointmentDate . 'T' . MedialDisplay::showTime($item->startingTime, '24') . '00Z';
				$end = $item->appointmentDate . 'T' . MedialDisplay::showTime($item->endingTime, '24') . '00Z';
				$start = str_replace(array('-',':') , '', $start);
				$end = str_replace(array('-',':') , '', $end);
				$summary = $item->name . ' ,' . $item->service;
				$code 	= $item->keyring;
				$uid = md5( $code . time() );

				$status = $item->published ? 
						JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_CONFIRMED') : JText::_('COM_EASYAPPOINTMENT_APPOINTMENTS_DETAILS_UNCONFIRMED');

				$description = $item->name . ' | ' . $code . ' | ' . $status;
				

				$this->content .= "BEGIN:VEVENT\n";

				$this->content .= "UID:$uid\n";
				$this->content .= "DTSTART;TZID=$tz:$start\n";
				$this->content .= "DTEND;TZID=$tz:$end\n";
				$this->content .= "SUMMARY:$summary\n";
				$this->content .= "DESCRIPTION:$description\n";
				$this->content .= "LOCATION:\n";
				$this->content .= "SEQUENCE:0\n";
				$this->content .= "STATUS:CONFIRMED\n";

				$this->content .= "END:VEVENT\n";
 			}

			$this->content .= "END:VCALENDAR\n";
		}
		return $this->content;
	}



}
?>
