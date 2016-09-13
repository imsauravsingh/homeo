<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialValidator
{

	// validate if hour can be used as possible booking hour
	// must check if no other booking is done in the interval (start->end)
	public static function isNodeFree($from,$to,$busy)
	{
		for ($i = $from; $i< $to; $i+= 300)
		{
			if (in_array($i, $busy))
			{
				return false;
			}
		}
		return true;
	}

	

}
?>
