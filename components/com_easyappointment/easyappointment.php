<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT . '/autoloader.php';

$controller	= JControllerLegacy::getInstance('Easyappointment');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>
