<?php
/**
 * @package     sauravkumar.in
 * @subpackage  mod_homeoslider
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once (dirname(__FILE__).DS.'helper.php');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

$services = modHomeosliderHelper::getServices();

 $Itemid = JRequest::getVar('Itemid');
//require (JModuleHelper::getLayoutPath('mod_homeoslider', 'services'));
if($Itemid==435){
  require JModuleHelper::getLayoutPath('mod_homeoslider', $params->get('layout', 'default'));
}else{
  require JModuleHelper::getLayoutPath('mod_homeoslider', $params->get('layout', 'filter'));
}
