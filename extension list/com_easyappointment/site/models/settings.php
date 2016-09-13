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

class EasyappointmentModelSettings extends JModelAdmin
{

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.settings', 'settings', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
		
		// display textareas as editor in case the email format is HTML (1)
		if (MedialStaff::getInstance()->getParams()->get('email_format') == 1)
		{
			$form->setFieldAttribute('send_email_body', 'type', 'editor');
			$form->setFieldAttribute('receive_email_body', 'type', 'editor');
		}
		
		return $form;
	}


	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.settings.data', array());
		if (!$data)
		{
			$user = MedialStaff::getInstance();
			$data = json_decode($user->params);
		}
		
		return $data;
	}


	public function save($data) 
	{	
		// store data in session
		JFactory::getApplication()->setUserState('com_easyappointment.edit.settings.data', $data);

		// filter data before saving
		$newdata = $this->filterBeforeSave($data);

		// services should contain only integers since we are dealing with ID
		JArrayHelper::toInteger($data['service']);

		// store data in db
		MedialStaff::getInstance()->store('services',json_encode($data['service']));
		MedialStaff::getInstance()->store('params',json_encode($newdata));
		return true;
	}


	/**
	 * make sure we do not save any unallowed values
	 * exclude services since this is going to saved separately
	 *
	 * @param [array] $data 		form values that should be saved
	 *
	 * @return [array] $newdata 	filtered form values
	 */
	protected function filterBeforeSave($data)
	{
		$form = $this->loadForm('com_easyappointment.settings', 'settings', array('control' => 'jform', 'load_data' => true));
		$filter = JFilterInput::getInstance();
		$newdata = array();


		foreach ($data as $key => $setting)
		{
			if ($key == 'service')
			{
				continue;
			} 
			elseif ($key == 'prices')
			{
				foreach ($data[$key] as $k=>$price)
				{
					preg_match('/[0-9.]{1,}/', $price, $matches);
					$newdata[$key][$k] = isset($matches[0]) ? (float) $matches[0] : 0;
				}
			}
			elseif ($key == 'service_length') 
			{
				foreach ($data[$key] as $k=>$length) 
				{
					$newdata[$key][$k] = (int) $length;
				}
			}
			else
			{
				$rule = $form->getFieldAttribute($key,'xrule');
				if ($rule)
				{
					preg_match($rule, $setting, $matches);
					$newdata[$key] = isset($matches[0]) ? $matches[0] : '';
				}
				else
				{
					$newdata[$key] = $filter->clean($setting,'raw');
				}
			}
		}
		
		return $newdata;
	}



}
?>
