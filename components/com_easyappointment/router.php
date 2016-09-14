<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright   Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

function EasyappointmentBuildRoute(&$query)
{
	$segments = array();
	$vars = array('view','task','id','service','category','d', 'layout');

	foreach ($vars as $var)
	{
		if (isset($query[$var])) {
			$segments[] = $query[$var];
			unset($query[$var]);
		}
	}

	return $segments;
}


function EasyappointmentParseRoute($segments)
{
	$vars = array();
	$count = count($segments);

	if ($count)
	{
		if (strpos($segments[0],'.') === false)
		{
			$vars['view'] = $segments[0];
		}
	}

	if ($segments[0] == 'user')
	{
		$vars['view'] = 'user';
		if(!empty($segments[1]))
		{
			$vars['id'] = $segments[1];
		}
		if(!empty($segments[2]))
		{
			$vars['service'] = $segments[2];
		}
	}

	if ($segments[0] == 'browse')
	{
		$vars['view'] = 'browse';
		if (!empty($segments[1]))
		{
			$vars['category'] = $segments[1];
		}
	}

	if ($segments[0] == 'logout')
	{
		$vars['task'] = 'logout';
	}

	if ($segments[0] == 'booking.edit')
	{
		$vars['task'] = 'booking.edit';
		if (!empty($segments[1]))
		{
			$vars['id'] = $segments[1];
		}
	}

	if ($segments[0] == 'booking')
	{
		$vars['view'] = 'booking';
		if (!empty($segments[1]))
		{
			$vars['id'] = $segments[1];
			$vars['layout'] = 'edit';
		}
	}

	if ($segments[0] == 'user.information')
	{
		if (!empty($segments[1]))
		{
			$vars['d'] = $segments[1];
		}
		$vars['task'] = 'user.information';
	}


	return $vars;
}
