<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewSpecial extends JViewLegacy
{
	protected $form;
	protected $user;
	protected $item;

	public function display($tpl = null) {

		$this->user = MedialStaff::getInstance();

		// if the user is not part of staff
		if (!$this->user->isStaff()) 
		{
			return false;
		}

		$this->form = $this->get('Form'); 
		$this->item = $this->get('Special');
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
		JHtml::script( 'components/com_easyappointment/assets/js/views/special.js' );
	}
}
?>
