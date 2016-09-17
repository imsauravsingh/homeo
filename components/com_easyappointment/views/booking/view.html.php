<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewBooking extends JViewLegacy
{
	protected $form;
	protected $state;
	protected $item;
	protected $staff;

	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->state = $this->get('State');
		$this->item = $this->get('Item'); 
		$this->staff = MedialStaff::getInstance();
		
		// if the user who tries to display the booking is not part of staff or he is not the owner of the reservation
		if (!$this->staff->isStaff() || ($this->item->staff && $this->staff->id != $this->item->staff)) 
		{
			return false;
		}

		$this->addResources();
		parent::display($tpl);
	}

	public function addResources() {	
		
		$scheme = JUri::getInstance()->getScheme();

		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
		JHtml::script( 'components/com_easyappointment/assets/js/tbb.js' );
		JHtml::script( 'components/com_easyappointment/assets/js/calendar.js' );
		JHtml::script( 'components/com_easyappointment/assets/js/views/booking.js' );
	}
}
?>
