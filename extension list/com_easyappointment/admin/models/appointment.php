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
class EasyappointmentModelAppointment extends JModelAdmin
{

	public function getTable($type = 'Appointments', $prefix = 'EasyappointmentTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}


	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.appointment', 'appointment', array('control' => 'jform', 'load_data' => $loadData)); 

		if (empty($form)) {
			return false;
		}

		// set proper values for date, start time and end time
		$form->setValue('appointmentDateV',null, MedialDisplay::showDate($form->getValue('appointmentDate')));
		$form->setValue('startingTimeV',null, MedialDisplay::showTime($form->getValue('startingTime')));
		$form->setValue('endingTimeV',null, MedialDisplay::showTime($form->getValue('endingTime')));
		
		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.appointment.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
}
?>
