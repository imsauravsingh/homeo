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

	protected $state;
	protected $bookings;
	protected $pagination;
	protected $statuses;
	protected $user;
	protected $selected;
	
	public function display($tpl = null)
	{
		$this->bookings = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->user = $this->get('User');
		$this->selected = $this->state->get('filter.bookings.datephp') ? 
							MedialDisplay::showDate($this->state->get('filter.bookings.datephp'), $this->user->getParams()->get('date_format')) :
							'';

		$this->statuses = array(JText::_('COM_EASYAPPOINTMENT_UNCONFIRMED'), JText::_('COM_EASYAPPOINTMENT_CONFIRMED'));

		// if the user is not part of staff
		if (!$this->user->isStaff()) 
		{
			return false;
		}
		
		$this->addResources();
		parent::display($tpl);
	}

	public function addResources() {	
	
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
		JHtml::script( 'components/com_easyappointment/assets/js/tbb.js' );
		JHtml::script( 'components/com_easyappointment/assets/js/calendar.js' );
		JHtml::script( 'components/com_easyappointment/assets/js/views/bookings.js' );
	}
}
?>
