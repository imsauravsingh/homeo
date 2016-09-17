<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modeladmin');
class EasyappointmentModelStaff extends JModelAdmin
{

	public function getTable($type = 'Staffs', $prefix = 'EasyappointmentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.staff', 'staff', array('control' => 'jform', 'load_data' => $loadData)); 

		if (empty($form)) {
			return false;
		}
		
		return $form;
	}


	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.staff.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	public function save($data) 
	{
		if (empty($data['user']))
		{
			$this->setError(JText::_('COM_EASYAPPOINTMENT_STAFFS_MUST_SELECT_A_USERNAME'));
			return false;
		}

		if ($data['id'])
		{
			parent::save($data);
		}
		else
		{
			$this->insertNew($data);
		}
		return true;
	}
	
	private function insertNew($data)
	{
		$filter = JFilterInput::getInstance();
		$columns = array(
			$this->_db->quoteName('id'),
			$this->_db->quoteName('user'),
			$this->_db->quoteName('name'),
			$this->_db->quoteName('description'),
			$this->_db->quoteName('picture'),
			$this->_db->quoteName('services'),
			$this->_db->quoteName('schedules'),
			$this->_db->quoteName('params'),
			$this->_db->quoteName('published'),
			$this->_db->quoteName('ordering'),
			$this->_db->quoteName('checked_out'),
		);
		$values = (int) $data['user'] .',' . (int) $data['user'] . ',' . $this->_db->quote($this->_db->escape($filter->clean($data['name'], 'html'))) . ',' .
					$this->_db->quote($this->_db->escape($filter->clean($data['description'], 'html'))) . ',' . $this->_db->quote($this->_db->escape($filter->clean($data['picture'], 'html'))) . ',' .
				 	'"","","",' . $data['published'] . ',"",0'; 

		$query = $this->_db->getQuery(true);
		$query->insert('#__make_appointment_staff');
		$query->columns($columns);
		$query->values($values);

		$this->_db->setQuery($query);
		$this->_db->query();
	}

	
}
?>
