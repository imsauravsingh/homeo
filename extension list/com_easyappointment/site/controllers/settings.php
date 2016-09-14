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

class EasyappointmentControllerSettings extends JControllerLegacy {

	public function save($key = NULL, $urlVar = NULL) 
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$data = JRequest::getVar('jform', array(), '', 'array');
		$data['prices'] = JRequest::getVar('service_price', array(), '', 'array');
		$data['service_length'] = JRequest::getVar('service_length', array(), '', 'array');
		
		$this->getModel('Settings')->save( $data );
		$this->setRedirect( JRoute::_('index.php?option=com_easyappointment&view=settings', false), JText::_('COM_EASYAPPOINTMENT_SETTINGS_SAVED'), 'message' );
		return true;
	}


}

?>
