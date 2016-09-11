<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');
class EasyappointmentControllerStaffs extends JControllerAdmin {
	
	protected	$option 		= 'com_easyappointment';
	protected 	$text_prefix	= 'COM_EASYAPPOINTMENTS_STAFFS';
	

	public function getModel($name = 'Staff', $prefix = 'EasyappointmentModel', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}


}
?>
