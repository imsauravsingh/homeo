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

class EasyappointmentModelSearch extends JModelAdmin
{

	protected $text_prefix = 'COM_EASYAPPOINTMENT';

	public function getTable($type = 'Reservation', $prefix = 'EasyappointmentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.search', 'search', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		
		return $form;
	}
	

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.search.data', array());
		
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}
	
	
}
?>
