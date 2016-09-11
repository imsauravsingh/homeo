<?php
/**
 * @version    2.7.x
 * @package    mod_homeoslider
 * @author     saurav http://www.sauravkumar.in
 * @copyright  Copyright (c) 2006 - 2016 sauravkumar Ltd. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;


class modhomeosliderHelper
{

	public static function getServices()
	{

		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__make_appointment_services WHERE published = 1 ORDER BY ordering ASC";
		$db->setQuery($query, 0, $limit);
		return $rows = $db->loadObjectList();
	}

}
