<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class EasyappointmentViewBrowse extends JViewLegacy
{	
	protected $items;
	protected $category;
	protected $view_type;


	public function display($tpl = null) 
	{
		$this->category = $this->get('Category');
		$this->items = $this->get('Items');
		$this->view_type = $this->get('ViewType');

		$this->addResources();

		parent::display($tpl);
	}
	
	
	public function addResources() 
	{	
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/bootstrap.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/css/style-front.css' );
		JHtml::stylesheet( 'components/com_easyappointment/assets/medial/style.css' );
	}
	
}
?>
