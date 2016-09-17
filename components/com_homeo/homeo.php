<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Homeo
 * @author     saurav <imsauravsingh@gmail.com>
 * @copyright  2016 saurav
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Homeo', JPATH_COMPONENT);
JLoader::register('HomeoController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Homeo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
