<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
class EasyappointmentViewAppointments extends JViewLegacy
{

	function display($tpl = null) {
		
		$basename		= $this->get('Basename');
		$filetype		= $this->get('FileType');
		$mimetype		= $this->get('MimeType');
		$content		= $this->get('Export');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// check if we send email
		$sendemail = JRequest::getVar('email', null, '', 'base64');
		if ( $sendemail ) {
			$config		= JFactory::getConfig();
			$recipient	= base64_decode( $sendemail );
			$attachment 	= $this->get('FileLocation');
			$fromName 	= $config->get('fromname');
			$from		= $config->get('mailfrom');
			if ( JFactory::getMailer()->sendMail( $from, $fromName, $recipient, $basename, $basename, $mode = false, $cc = null, $bcc = null, $attachment ) ) {
				jimport('joomla.filesystem.file');
				JFile::delete( $attachment );
			}
			sleep(3);
		}
 

		$document = JFactory::getDocument();
		$document->setMimeEncoding($mimetype);
		JResponse::setHeader('Content-disposition', 'attachment; filename="'.$basename.'.'.$filetype.'"; creation-date="'.JFactory::getDate()->toRFC822().'"', true);
		echo $content;
		
	}
	
	
	
}
?>
