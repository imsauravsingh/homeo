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
class EasyappointmentModelServices extends JModelList
{	
	
	public function __construct($config = array()) {

		parent::__construct($config);
	}
	
	protected function populateState( $ordering = null, $direction = null ) { 
		
		// Initialise variables.
		$app = JFactory::getApplication('administrator');
		
		$state = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search', '', 'string');
		$this->setState('filter.search', $state);

		parent::populateState('a.id', 'desc');
	}
	
	
	protected function getStoreId($id = '') {

		$id	.= ':'.$this->getState('filter.search');

		return parent::getStoreId($id);
	}
	

	protected function getListQuery() {
		
		// get current parent
		$parent = JRequest::getVar('parent', 0, '','int');

		// Create a new query object.
		$query	= $this->_db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select','a.id, a.name, a.price, a.published, a.length'
			)
		);
		$query->from(' #__make_appointment_services AS a ');
		$query->where('a.parent = ' . $parent );

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
				$query->where('( LOWER(a.name) LIKE '.$search.')');
			}
		}
		
		// Add the list ordering clause.
		$orderCol = $this->getState('list.ordering', 'a.id');
		$query->order($this->_db->escape($orderCol).' '.$this->_db->escape($this->getState('list.direction', 'DESC')));

		return $query;
	}
	


	
}
?>
