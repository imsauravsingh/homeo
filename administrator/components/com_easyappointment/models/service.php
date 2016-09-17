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
class EasyappointmentModelService extends JModelAdmin
{

	public function getTable($type = 'Service', $prefix = 'EasyappointmentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.service', 'service', array('control' => 'jform', 'load_data' => $loadData)); 

		if (empty($form)) {
			return false;
		}
		
		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.service.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}


	public function delete(&$pks) 
	{	
		$todelete = array();

		foreach ($pks as $parent)
		{
			$todelete[] = $parent;
			$childrens = MedialServices::getInstance()->getChildrens($parent);
			if ($childrens)
			{
				foreach ($childrens as $children)
				{
					$todelete[] = $children->id;
				}
			}
		}

		$query = $this->_db->getQuery(true);
		$query->delete();
		$query->from('#__make_appointment_services');
		$query->where('id IN ('.implode(',',$todelete).')');	
		
		$this->_db->setQuery($query);
		$this->_db->query();

		return true;
	}
	

	
}
?>
