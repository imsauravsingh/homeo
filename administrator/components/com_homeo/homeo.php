<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Homeo
 * @author     saurav <imsauravsingh@gmail.com>
 * @copyright  2016 saurav
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_homeo'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Homeo', JPATH_COMPONENT_ADMINISTRATOR);

$controller = JControllerLegacy::getInstance('Homeo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
