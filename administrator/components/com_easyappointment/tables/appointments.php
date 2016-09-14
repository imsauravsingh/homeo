<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class EasyappointmentTableAppointments extends JTable {

	public function __construct(&$db) {
		parent::__construct('#__make_appointment_reservations', 'id', $db);
	}


}
?>
