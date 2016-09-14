<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class EasyappointmentControllerInformation extends JControllerLegacy
{

	// validate input data and proceed to next step
	public function next()
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
		$model = $this->getModel('Information');

		// get input data
		$data = JFactory::getApplication()->input->get('jform',array(),'');

		// if empty data return to info page
		if (empty($data))
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=information'));
			return false;
		}

		// store data in session
		JFactory::getApplication()->setUserState('com_easyappointment.edit.information.data', $data);

		// validate form and clean data
		$form = $model->getForm();
		$return = $model->validateForm($form, $data);
		if (!$return)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=information'), $model->getError(), 'error');
			return false;
		}

		// store data in session after validation and cleaning
		JFactory::getApplication()->setUserState('com_easyappointment.edit.information.data', $data);

		// validate data logic before going to next step
		if (!$model->validateDataLogic($data))
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=information'), $model->getError(), 'error');
			return false;
		}

		$staff = MedialStaff::getInstance($data['staff']);
		$appointment = new MedialAppointment();
		$appointment->bind($data);
		$client_must_confirm = $staff->getParams()->get('client_must_confirm');

		// check if staff wants only registered users to be able to continue
		if($staff->getParams()->get('client_must_be_registered') && !JFactory::getUser()->id)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=browse', false), JText::_('COM_EASYAPPOINTMENT_CLIENT_MUST_BE_REGISTERED_PROHIBITED'), 'error');
			return false;
		}

		// generate the confirmation code
		$confirmation = new MedialConfirmation($staff, $appointment);
		$data['keyring'] = $confirmation->createCode();
		$data['published'] = $staff->getParams()->get('booking_status');

		// store confirmation code
		JFactory::getApplication()->setUserState('com_easyappointment.edit.information.data', $data);

		if ($client_must_confirm)
		{
			if(!$confirmation->sendCode())
			{
				$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=information'), JText::_('COM_EASYAPPOINTMENT_ERROR_SENDING_CONFIRMATION'), 'error');
				return false;
			}
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=confirmation'));
		}
		else
		{
			$app = $this->saveAppointment($data);
			$staff->sendNotification($app);
			$staff->receiveNotification($app);
			$this->unsetData($data);
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=finish'));
		}

		return true;
	}


	// save and return the appointment object to be used in confirmation process
	protected function saveAppointment($item)
	{
		$item['user'] = JFactory::getUser()->get('id');
		$appointment = new MedialAppointment();
		$appointment->bind($item);
		$appointment->insert();

		return $appointment;
	}


	// change existing data to other variable
	protected function unsetData($item)
	{
		JFactory::getApplication()->setUserState('com_easyappointment.finish.data', $item);
		JFactory::getApplication()->setUserState('com_easyappointment.edit.information.data', array());
	}

}
?>
