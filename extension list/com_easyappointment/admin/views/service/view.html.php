<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewService extends JViewLegacy
{
	protected $item;
	protected $form;
	protected $state;

	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->item			= $this->get('Item');
		$this->form			= $this->get('Form'); 

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
		$isNew	= ($this->item->id == 0);
	
		if ($isNew) {
			JToolBarHelper::title(   'EasyAppointment :: ' . JText::_( 'COM_EASYAPPOINTMENT_SERVICES_NEW' ), 'services' );	
		} else {
			JToolBarHelper::title(   'EasyAppointment :: ' . JText::_( 'COM_EASYAPPOINTMENT_SERVICES_EDIT' ), 'services' );	
		}


		// If not checked out, can save the item.
		if ($canDo->get('core.edit')||($canDo->get('core.create'))) {
			JToolBarHelper::apply('service.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('service.save', 'JTOOLBAR_SAVE');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('service.cancel','JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('service.cancel', 'JTOOLBAR_CLOSE');
		}
		
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/css/bootstrap.css');
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/medial/style.css');
	}
}
?>
