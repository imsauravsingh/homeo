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
class EasyappointmentControllerAppointments extends JControllerAdmin {
	
	protected	$option 		= 'com_easyappointment';
	protected 	$text_prefix 	= 'COM_EASYAPPOINTMENTS_APPOINTMENT';

	public function getModel($name = 'Appointment', $prefix = 'EasyappointmentModel', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
		
	public function export() {
		
		$form = JRequest::getVar('jform', array(), '', 'array' );

		$basename 	= $form['basename'] ? filter_var( $form['basename'], FILTER_SANITIZE_ENCODED ) : null;
		$email 		= $form['email'] ? filter_var( $form['email'], FILTER_SANITIZE_EMAIL ) : null;
		$format		= filter_var( $form['format'], FILTER_SANITIZE_STRING );

		JFactory::getApplication()->setUserState('export.details', array('basename'=>$basename, 'email'=>$email, 'format'=>$format));

		$this->setRedirect( 'index.php?option=com_easyappointment&view=appointments&format=export&tmpl=component', false );
		return true;
	}
	
}

?>
