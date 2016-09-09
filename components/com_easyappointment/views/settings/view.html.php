<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewSettings extends JViewLegacy
{
	protected $form;

	public function display($tpl = null) {

		$this->form = $this->get('Form');
		$user = MedialStaff::getInstance();

		// if the user is not part of staff
		if (!$user->isStaff()) 
		{
			return false;
		}
		
		$this->addResources();
		parent::display($tpl);
	}
	
	
	public function addResources() 
	{	
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
		JHtml::script( 'components/com_easyappointment/assets/js/tbb.js' );
		JHtml::script( 'components/com_easyappointment/assets/js/views/settings.js' );
	}
}
?>
