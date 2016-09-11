<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewUser extends JViewLegacy
{	
	protected $user;
	protected $service;
	protected $calendar;
	protected $layout;

	public function display($tpl = null) 
	{
		$this->user = $this->get('User');
		$this->service = $this->get('Service');
		$this->layout = $this->get('Layout');
		$calendar = $this->get('Calendar');		
		$this->calendar = MedialDisplay::buildCalendar($this->user,$this->service,$calendar);

		$this->addResources();

		parent::display($tpl);
	}
	
	
	public function addResources() 
	{	
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style-front.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
		JHtml::script('components/com_easyappointment/assets/js/tbb.js');
		JHtml::script('components/com_easyappointment/assets/js/views/user.js');
	}
	
}
?>
