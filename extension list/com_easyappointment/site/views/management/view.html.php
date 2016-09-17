<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewManagement extends JViewLegacy
{
	protected $bookings;
	protected $staff;

	public function display($tpl = null) {		
		
		$this->bookings = $this->get('TodayBookings');
		$this->staff = $this->get('User');
		
		if (!$this->staff->isStaff()) 
		{
			return false;
		}
		$this->addResources();
	
		parent::display($tpl);
	}
	
	
	public function addResources() 
	{	
		$scheme = JUri::getInstance()->getScheme();

		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
	}
	
}
?>
