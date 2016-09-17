<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
class EasyappointmentViewServices extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	function display($tpl = null) {
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

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
		
		JToolBarHelper::title(   'EasyAppointment :: ' . JText::_( 'COM_EASYAPPOINTMENT_SERVICES' ), 'services' );
		
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('service.add', 'JTOOLBAR_NEW');
		}
		
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('service.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.delete')) {
			JToolBarHelper::custom('services.delete', 'delete.png', 'delete.png', 'JTOOLBAR_DELETE' , true);
		}
		
		JToolBarHelper::divider();
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_easyappointment');
		}		
		
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/css/bootstrap.css');
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/medial/style.css');
	}
	
}
?>
