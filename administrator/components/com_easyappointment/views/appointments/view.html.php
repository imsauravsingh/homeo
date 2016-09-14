<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
class EasyappointmentViewAppointments extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $staff;
	protected $services;
	protected $datepicker;

	function display($tpl = null) {
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->staff		= $this->get('Staff'); 
		$this->services 	= $this->get('Services');

		MedialMenu::addSubmenu();
		$this->sidebar = JHtmlSidebar::render();
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
		parent::display($tpl);
		
	}
	
	
	public function addToolbar() {	
		
		$canDo	= JoomlaAclEA::getActions();
		
		JToolBarHelper::title(   'EasyAppointment :: ' . JText::_( 'COM_EASYAPPOINTMENT_APPOINTMENTS' ), 'bookings' );

		$bhtml = '<button type="button" class="btn btn-small" data-toggle="modal" data-target="#myModal">'.JText::_('JTOOLBAR_EXPORT').'</button>';
		JToolBar::getInstance('toolbar')->appendButton('Custom', $bhtml);
	

		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('appointment.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.delete')) {
			JToolBarHelper::custom('appointments.delete', 'delete.png', 'delete.png', 'JTOOLBAR_DELETE' , true);
		}
		
		JToolBarHelper::divider();
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_easyappointment');
		}	
		
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/css/bootstrap.css');
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/medial/style.css');
		JHtml::script('administrator/components/com_easyappointment/assets/js/calendar.js');
		JHtml::script('administrator/components/com_easyappointment/assets/js/tbb.js');
	}
	
}
?>
