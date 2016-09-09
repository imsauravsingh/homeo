<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JLoader::register('MedialDisplay', JPATH_COMPONENT.'/lib/display.php');
JLoader::register('MedialStaff', JPATH_COMPONENT.'/lib/staff.php');
JLoader::register('MedialStaffParams', JPATH_COMPONENT.'/lib/staffParams.php');
JLoader::register('MedialStaffSchedule', JPATH_COMPONENT.'/lib/staffSchedule.php');
JLoader::register('MedialService', JPATH_COMPONENT.'/lib/service.php');
JLoader::register('MedialServices', JPATH_COMPONENT.'/lib/services.php');
JLoader::register('MedialSearch', JPATH_COMPONENT.'/lib/search.php');
JLoader::register('MedialCalendar', JPATH_COMPONENT.'/lib/calendar.php');
JLoader::register('MedialValidator', JPATH_COMPONENT.'/lib/validator.php');
JLoader::register('MedialConfirmation', JPATH_COMPONENT.'/lib/confirmation.php');
JLoader::register('MedialAppointment', JPATH_COMPONENT.'/lib/appointment.php');
