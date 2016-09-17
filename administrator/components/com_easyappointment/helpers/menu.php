<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

class MedialMenu 
{
	public static function addSubmenu()
	{
		$view = JRequest::getVar('view');
		JHtmlSidebar::addEntry( JText::_( 'COM_EASYAPPOINTMENT_SERVICES' ), 'index.php?option=com_easyappointment&view=services', $view == 'services' );
		JHtmlSidebar::addEntry( JText::_( 'COM_EASYAPPOINTMENT_STAFF' ), 'index.php?option=com_easyappointment&view=staffs', $view == 'staffs' );
		JHtmlSidebar::addEntry( JText::_( 'COM_EASYAPPOINTMENT_APPOINTMENTS' ), 'index.php?option=com_easyappointment&view=appointments', $view == 'appointments' );
		JHtmlSidebar::addEntry( JText::_( 'COM_EASYAPPOINTMENT_ABOUT' ), 'index.php?option=com_easyappointment&view=about', $view == 'about' );
	}
}




