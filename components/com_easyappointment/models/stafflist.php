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

class EasyappointmentModelStafflist extends JModelList
{

	public function __construct($config = array()) 
	{
		parent::__construct($config);
	}
	

	protected function getStoreId($id = '') 
	{
		return parent::getStoreId($id);
	}


	public function getListQuery() 
	{
		$query = $this->_db->getQuery(true);
		$query->select('id,name,description,picture');
		$query->from($this->_db->quoteName('#__make_appointment_staff'));

		return $query;
	}
}
