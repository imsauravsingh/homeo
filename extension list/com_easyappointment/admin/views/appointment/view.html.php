<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewAppointment extends JViewLegacy
{
	protected $item;
	protected $form;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form'); 

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar() {
	
		$canDo	= JoomlaAclEA::getActions();
		JToolBarHelper::title(   'EasyAppointment :: ' . JText::_( 'COM_EASYAPPOINTMENT_APPOINTMENTS_EDIT' ), 'appointments' );	

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('appointment.cancel','JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('appointment.cancel', 'JTOOLBAR_CLOSE');
		}
		
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/css/bootstrap.css');
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/medial/style.css');
	}
}
?>
