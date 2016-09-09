<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewBookings extends JViewLegacy
{
	protected $content;
	protected $exported;

	public function display($tpl = null)
	{
		// if the user is not part of staff
		$user = $this->get('User');	
		if (!$user->isStaff()) 
		{
			return false;
		}

		$this->content = $this->get('ExportContent');
		$this->exported = $this->get('Export');

		$document = JFactory::getDocument();
		$document->setMimeEncoding($this->exported->mimetype);
		JResponse::setHeader('Content-disposition', 'attachment; filename="'.$this->exported->basename.'.'.$this->exported->filetype.'"; creation-date="'.JFactory::getDate()->toRFC822().'"', true);
		echo $this->content;
	}


}
?>
