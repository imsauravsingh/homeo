<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewAbout extends JViewLegacy
{
	protected $info;

	function display($tpl = null) {
		
		$this->info = new SimpleXMLElement( JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'easyappointment.xml', null, true );

		MedialMenu::addSubmenu();
		$this->sidebar = JHtmlSidebar::render();

		$this->addToolbar();
		parent::display($tpl);
		
	}
	
	
	public function addToolbar() {	
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/css/bootstrap.css');
		JHtml::stylesheet('administrator/components/com_easyappointment/assets/medial/style.css');
		JToolBarHelper::title(   'EasyAppointment :: ' . JText::_( 'COM_EASYAPPOINTMENT_ABOUT' ), 'about' );
	}
	
}
?>
