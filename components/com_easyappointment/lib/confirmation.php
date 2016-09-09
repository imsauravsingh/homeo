<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialConfirmation extends JObject
{
	private $staff;
	private $appointment;
	private $mailer;
	private $subject;
	private $body;
	private $from_email;
	private $to_email;
	private $from_name;
	private $code;
	

	public function __construct(MedialStaff $staff, MedialAppointment $appointment)
	{
		$this->staff = $staff;
		$this->appointment = $appointment;
		$this->mailer = JFactory::getMailer();
	}


	public function setSubject($subject)
	{
		$this->subject = $this->stripTags($subject);
	}


	public function setBody($body)
	{
		$this->body = $this->stripTags($body);
	}


	public function setFromEmail($email)
	{
		$this->from_email = $email;
	}


	public function setFromName($name)
	{
		$this->from_name = $name;
	}


	public function setToEmail($email)
	{
		$this->to_email = $email;
	}


	public function send()
	{
		$html = ($this->staff->getParams()->get('email_format') == 1) ? true : false;
		$this->mailer->sendMail($this->from_email, $this->from_name, $this->to_email, $this->subject, $this->body, $html);
	}



	/**
	 * create the code to be sent during the appointment process
	 * if the confirmation step is not mandatory, this code will be stored so that it can be retrieved at a later time 
	 */
	public function createCode()
	{
		$this->code = substr(time(), -4,4);
		return $this->code;
	}


	/**
	 * send by email the code required for client to confirm the appointment during the process
	 * client must use this code in the "confirmation" view
	 */
	public function sendCode() 
	{
		$sent = $this->mailer->sendMail(
			$this->mailer->From, 
			$this->staff->name, 
			$this->appointment->email, 
			JText::_('COM_EASYAPPOINTMENT_CONFIRMATION_CODE_SUBJECT'), 
			sprintf(JText::_('COM_EASYAPPOINTMENT_CONFIRMATION_CODE_BODY'),$this->code)
		);

		if (!$sent) 
		{
			$this->setError($this->mailer->getError());
			return false;
		}

		return true;
	}


	/**
	 * replace tags in notification subject/body
	 */
	protected function stripTags($data)
	{
		$tags = array(
			'%date%'=>MedialDisplay::showDate($this->appointment->appointmentDate, $this->staff->getParams()->get('date_format')),
			'%from%'=>MedialDisplay::showTime($this->appointment->startingTime, $this->staff->getParams()->get('hour_format')),
			'%to%'=>MedialDisplay::showTime($this->appointment->endingTime, $this->staff->getParams()->get('hour_format')),
			'%name%'=>$this->appointment->name,
			'%email%'=>$this->appointment->email,
			'%phone%'=>$this->appointment->phone,
			'%comments%'=>$this->appointment->comments,
			'%confirmation_url%'=>JUri::root() .'index.php?option=com_easyappointment&task=booking.confirm&k=' . $this->appointment->keyring . '&e=' . base64_encode($this->appointment->email),
			'%cancelation_url%'=>JUri::root() .'index.php?option=com_easyappointment&task=booking.canceled&k=' . $this->appointment->keyring . '&e=' . base64_encode($this->appointment->email),
			'%service%'=>MedialService::getInstance($this->appointment->service)->name,
		);

		foreach ($tags as $tag=>$value)
		{
			$data = str_replace($tag, $value, $data);
		}

		return $data;
	}
}

?>
