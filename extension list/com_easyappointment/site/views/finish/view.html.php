<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewFinish extends JViewLegacy
{	
	protected $item;
	protected $user;
	protected $service;

	public function display($tpl = null) 
	{
		$this->item = $this->get('ReservationItem');
		$this->user = $this->get('User');
		$this->service = $this->get('Service');
		$this->addResources();

		parent::display($tpl);
	}
	
	
	public function addResources() 
	{	
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style-front.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/steps.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
	}
	
}
?>
