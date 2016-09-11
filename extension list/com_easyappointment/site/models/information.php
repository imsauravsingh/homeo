<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');

class EasyappointmentModelInformation extends JModelForm
{
	protected $text_prefix = 'COM_EASYAPPOINTMENT';
	protected $default_data;

	public function __construct()
	{
		$this->default_data = array('staff'=>0,'service'=>0,'appointmentDate'=>'0000-01-01', 'startingTime'=>0);
		parent::__construct();
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_easyappointment.information', 'information', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		$this->setUserPreferences($form);

		return $form;
	}


	public function getReservationItem()
	{
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.information.data', $this->default_data);
		$data = empty($data) ? $this->default_data : $data;

		// if client is a logged in user, populate name/email field
		$user = JFactory::getUser();
		if ($user->id)
		{
			$data['name'] = $user->name;
			$data['email'] = $user->email;
		}

		return $data;
	}


	public function getUser()
	{
		$data = $this->getReservationItem();
		return MedialStaff::getInstance($data['staff']);
	}


	public function getService()
	{
		$data = $this->getReservationItem();
		return MedialService::getInstance($data['service']);
	}


	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = $this->getReservationItem();
		return $data;
	}


	/**
	 *  as default the form xml specify only name as required from all the fields that can be completed by a user
	 *  this will modify some of the form field attributes according to the selected staff preferences
	 *  the staff can specify in his options which fields to be available and if these fields to be required
	 *
	 * 	@param [object] [$form] [JForm object containing the form data and fields]
	 *
	 * 	@return [object] [modified JForm object containing staff preferences]
	 */
	protected function setUserPreferences(&$form)
	{
		// set user preferences
		$params = $this->getUser()->getParams();
		$fields = array('email','phone', 'address', 'comments');

		foreach ($fields as $field)
		{
			if (!$params->get('show_form_'.$field))
			{
				$form->setFieldAttribute($field, 'class', 'hidden');
				$form->setFieldAttribute($field, 'label', '');
			}
			else
			{
				if ($params->get('mandatory_form_'.$field))
				{
					$form->setFieldAttribute($field, 'required', 'true');
				}
			}
		}
	}


	/**
	 * before proceeding to the next step check logic of input data from user
	 * check if the staff is available 
	 * check if date is not in the past
	 * check if starting hour is not after ending hour
	 *
	 * @param [array] [$data] [input from user]
	 * @return [boolean] [true if data logic is correct, false if incorrect]
	 */
	public function validateDataLogic($data)
	{
		// check if selected date is not in the past
		$tz = new DateTimeZone(JFactory::getApplication()->getCfg('offset'));
        $now = JFactory::getDate('now',$tz);
        $user = MedialStaff::getInstance($data['staff']);
        $rez = true;

        if ($data['appointmentDate'] < $now->format('Y-m-d', true))
        {
			$this->setError(JText::_('COM_EASYAPPOINTMENT_ERROR_DATE_IN_PAST'));
			$rez = false;
		}
		elseif ($data['appointmentDate'] == $now->format('Y-m-d', true))
		{	
			if ($data['startingTime'] < MedialDisplay::hourToTime($now->format('H:i', true)))
			{
				$this->setError(JText::_('COM_EASYAPPOINTMENT_ERROR_TIME_IN_PAST'));
				$rez = false;
			}
		}

		// check if selected end hour is not smaller than selected start hour
		if ($data['startingTime'] >= $data['endingTime'])
		{
			$this->setError(JText::_('COM_EASYAPPOINTMENT_ERROR_START_END_HOURS'));
			$rez = false;
		}

		// check if staff is available for this date and this interval
		$options = array('date'=>$data['appointmentDate'], 'starthour'=>$data['startingTime'], 'endhour'=>$data['endingTime']);
		if (!$user->isAvailable($options))
		{
			$rez = false;
			$this->setError($user->search->getError());
		}
	
		return $rez;
	}


	/**
	 * validate against defined field pattern 
	 * clean input data
	 * @param [object] [$form] [JForm object containing the form data and fields]
	 * @param [array] [$data] [current input data]
	 *
	 * @return [boolean] [true if data satisfy defined requirements, false if not]
	 */
	public function validateForm($form,&$data)
	{
		$filter = JFilterInput::getInstance();

		foreach ($form->getFieldsets() as $fieldset)
		{
			$fields = $form->getFieldset($fieldset->name);
			foreach ($fields as $field)
			{
				// required field & empty data
				if ($field->required && empty($data[$field->fieldname]))
				{
					$this->setError(sprintf(JText::_('COM_EASYAPPOINTMENT_ERROR_VALIDATE_FIELD'),$field->label));
					return false;
				}

				// regex match
				if ($field->validate && !empty($data[$field->fieldname]))
				{
					$data[$field->fieldname] = trim($data[$field->fieldname]);

					preg_match($field->validate, $data[$field->fieldname],$matches);
					if (empty($matches[0]))
					{
						$this->setError(sprintf(JText::_('COM_EASYAPPOINTMENT_ERROR_VALIDATE_FIELD'),$field->label));
						return false;
					}
					$data[$field->fieldname] = $matches[0];
				}
				else
				{
					$data[$field->fieldname] = $filter->clean($data[$field->fieldname],'string');
				}
			}
		}

		return true;
	}
	
}
?>
