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

class EasyappointmentControllerBooking extends JControllerForm 
{

	private $isAjaxRequest = false;


	public function save($key = 'NULL', $urlVar = NULL) 
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));	
		
		$model = $this->getModel('Booking');
		$form = $model->getForm();
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$app  = JFactory::getApplication();
		
		// set staff if no staff defined (management area)
		if (empty($data['staff']))
		{	
			$data['staff'] = $this->getStaff();
		}
	
		// clean data before saving it
		$data = $model->cleanData($data);

		// set data in session
		$app->setUserState('com_easyappointment.edit.booking.data', $data);

		// Validate the posted data.
		$return = $model->validate($form, $data);
		
		// Check for form validation errors.
		if ($return == false)
		{
			$errors = $model->getErrors();
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=booking&layout=edit'), implode('<br/>', $errors), 'warning');
			return false;
		}

		// check input integrity and staff availability
		$return = $model->verify($data);

		// errors
		if ($return == false)
		{
			$errors = $model->getErrors();
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=booking&layout=edit'), implode('<br/>', $errors), 'warning');
			return false;
		}

		// create keyring
		$data['keyring'] = $data['staff'] . $data['service'] . 
				substr($data['appointmentDate'], -2, 2) . 
				substr($data['appointmentDate'], -5, 2) . 
				str_replace(':','',MedialDisplay::showTime($data['startingTime'],24)) . 
				substr(time(), -4,4);

		if ($model->save($data)) 
		{		
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=bookings',false));
			return true;
		}
	}


	public function close()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=bookings',false));
		return false;
	}


	/**
	 * confirm a reservation by using the link from the email
	 * this should be avoided, normally if confirmation is required should be selected as an extra step during the process
	 */
	public function confirm()
	{
		$app = new MedialAppointment;
		if ($this->checkValidEmailKeyring())
		{
			$data = $this->getEmailKeyring();
			$app->confirm($data['keyring'],$data['email']);
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=search'), JText::_('COM_EASYAPPOINTMENT_RESERVATION_CONFIRMED'), 'message');
			return;
		}
	}


	/**
	 * cancel(delete) a reservation using a link
	 */
	public function canceled()
	{
		$app = new MedialAppointment;
		if ($this->checkValidEmailKeyring())
		{
			$data = $this->getEmailKeyring();
			$app->unconfirm($data['keyring'],$data['email']);
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=search'), JText::_('COM_EASYAPPOINTMENT_RESERVATION_UNCONFIRMED'), 'message');
			return;
		}
	}


	protected function getEmailKeyring()
	{
		$url = array();
		$keyring = JRequest::getVar('k','');
		$email = JRequest::getVar('e','');
		$email = $email ? base64_decode($email) : $email;
		$url['keyring'] = $keyring;
		$url['email'] = $email;

		return $url;
	}


	/**
	 * check for valid email format and valid keyring format in the confirmation/cancelation url
	 */
	protected function checkValidEmailKeyring()
	{
		$data = $this->getEmailKeyring();
		if (preg_match('/[0-9]{1,}/', $data['keyring']) && preg_match('/^[A-Za-z0-9-\._]{1,}@[\w-\.]*\.[\w]{2,}$/', $data['email']))
		{
			return true;
		}
		return $data;
	}


	// get staff member in case the booking is made by staff member in management area
	protected function getStaff()
	{
		if (MedialStaff::getInstance()->isStaff()) 
		{
			return MedialStaff::getInstance()->id;
		}
		return 0;
	}
}

?>
