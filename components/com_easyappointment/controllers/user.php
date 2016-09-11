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

class EasyappointmentControllerUser extends JControllerLegacy
{
	
	public function information()
	{
		//JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));	

		$data = JFactory::getApplication()->input->get('d');
		
		// no data in the url
		if (!$data)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=browse'), JText::_('COM_EASYAPPOINTMENT_WARNING_NO_DATA_SET'), 'warning');
		}
		else
		{
			$data = (array) $this->getSelectedNode($data);
			JFactory::getApplication()->setUserState('com_easyappointment.edit.information.data', $data);
			$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=information'));
		}
	}


	// get details selected by user in the previous step 
	protected function getSelectedNode($data)
	{
		$node = new stdclass;
		$node->appointmentDate = '';
		$node->startingTime = 0;
		$node->endingTime = 0;
		$node->service = 0;
		$node->staff = 0;
		$node->user = 0;

		if ($data)
		{
			$node = json_decode(base64_decode($data));
		}

		return $node;
	}

}
?>
