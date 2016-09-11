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

class EasyappointmentControllerConfirmation extends JControllerLegacy
{

	// validate input data and proceed to next step
	public function finish()
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));

		// get input data
		$data = JFactory::getApplication()->input->get('jform',array(),'');
		$model = $this->getModel('Confirmation');
		$form = $model->getForm();
		$item = $model->getReservationItem();
		$user = MedialStaff::getInstance($item['staff']);

		// check if staff wants only registered users to be able to continue
		if($user->getParams()->get('client_must_be_registered') && !JFactory::getUser()->id)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=browse', false), JText::_('COM_EASYAPPOINTMENT_CLIENT_MUST_BE_REGISTERED_PROHIBITED'), 'error');
			return false;
		}

		if (!$model->validateForm($form, $data))
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=confirmation'), sprintf(JText::_('COM_EASYAPPOINTMENT_ERROR_VALIDATE_FIELD'), $model->getError()), 'error');
			return false;
		}

		// if confirmed code
		if ($data['code'] == $item['keyring'])
		{
			// check one more time if staff is available for this date/time
			$options = array('date'=>$item['appointmentDate'], 'starthour'=>$item['startingTime'], 'endhour'=>$item['endingTime']);
			if (!$user->isAvailable($options))
			{
				$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=confirmation'), JText::_('COM_EASYAPPOINTMENT_ERROR_STAFF_NOT_AVAILABLE_FOR'), 'error');
				return false;
			}

			// everything checked, set appointment status to 1 (confirmed), save/update the appointment and redirect to finish page
			if (empty($item['id']))
			{
				$item['keyring'] = 	$item['staff'] . $item['service'] .
									substr($item['appointmentDate'], -2, 2) .
									substr($item['appointmentDate'], -5, 2) .
									str_replace(':','',MedialDisplay::showTime($item['startingTime'],24)) .
									$item['keyring'];
				$app = $this->saveAppointment($item);
				$user->sendNotification($app);
				$user->receiveNotification($app);
			}
			else
			{
				$this->updateAppointment($item);
			}
			$this->unsetData($item);
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=finish'));
		}
		else
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=confirmation'), JText::_('COM_EASYAPPOINTMENT_ERROR_KEYRING'), 'error');
			return false;
		}
		return;
	}


	protected function saveAppointment($item)
	{
		$item['published'] = 1;
		$item['user'] = JFactory::getUser()->get('id');
		$appointment = new MedialAppointment();
		$appointment->bind($item);
		$appointment->insert();
		return $appointment;
	}


	protected function unsetData($item)
	{
		JFactory::getApplication()->setUserState('com_easyappointment.finish.data', $item);
		JFactory::getApplication()->setUserState('com_easyappointment.edit.information.data', array());
	}
}
?>
