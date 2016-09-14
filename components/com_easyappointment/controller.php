<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

class EasyappointmentController extends JControllerLegacy {

	function display($cachable = false, $urlparams = false) {
		parent::display();
	}


	public function logout()
	{
		JFactory::getApplication()->logout();
		JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_easyappointment&view=search',false));
	}
}
