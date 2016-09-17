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

class EasyappointmentModelConfirmation extends JModelForm
{
	protected $text_prefix = 'COM_EASYAPPOINTMENT';
	protected $default_data;

	public function __construct()
	{
		$this->default_data = array('staff'=>0,'service'=>0,'appointmentDate'=>'0000-01-01', 'startingTime'=>0, 'keyring'=>'');
		parent::__construct();
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_easyappointment.confirmation', 'confirmation', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}


	public function getReservationItem()
	{
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.information.data', $this->default_data);
		$data = empty($data) ? $this->default_data : $data;
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
		$data = $this->getReservationItem();
		return $data;
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
				$data[$field->fieldname] = trim($data[$field->fieldname]);

				if ($field->validate)
				{
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
