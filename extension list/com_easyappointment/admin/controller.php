<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */ 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );

class EasyappointmentController extends JControllerLegacy {
	
	function display($cachable = false, $urlparams = false) {

		$view = JRequest::getVar('view', null, '', 'string');
		if (empty($view)) {
			$this->setRedirect('index.php?option=com_easyappointment&view=services');
			return;
		}
		parent::display();
	}
	
}
?>
