<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialDisplay
{
    
    public static function loadMenu() 
    {
    	$path = JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR  . 'default_menu.php';
    	require_once( $path );
    }
    
    
    /*
     * method to display properly formatted time
     * @params $time (int) time value in seconds
     * @params $timeformat (string) restaurant time format param value
     *
     * return (string) hour formatted according to settings, if no settings default to 12 hours format
     */
    public static function showTime( $time, $timeformat = '12' )
    {
	  if ( !$time )
	  {
		return false;	
	  }

	  $hour = '';
	  
	  $hours = floor($time / 3600);
	  $minutes = ($time-($hours*3600))/60;
	  $minutes = ( strlen( $minutes ) < 2 ) ? '0' . $minutes : $minutes;
	  
	  switch ( $timeformat )
	  {
		case '24' :
		    $hour = $hours . ':' . $minutes;
		break;
	  
		case '12':
		default:
			if ( $hours == 12 ) 
			{
				$hour = '12:' . $minutes . ' PM';
			} 
			else 
			{
				$hour = ( $hours > 12 ) ? ($hours - 12) . ':' . $minutes . ' PM' : $hours . ':' . $minutes . ' AM';
			}
		break;
	  }
	  return $hour;
    }


    /**
     * display date in the chosen format
     * 
     * @param  [type] $date   [date/timestamp]
     * @param  string $format [default to YYYY-mm-dd]
     * @return [string]
     */
    public static function showDate($date, $format = 'Y-m-d')
    {
        $formated = $date;
        $parts = explode('-',$date);
        $months = self::showMonths('cal');

        $translation['Y'] = $parts[0];
        $translation['m'] = $parts[1];
        $translation['d'] = $parts[2];
        $translation['F'] = $months[$parts[1]-1];
        $translation['M'] = substr($translation['F'], 0, 3);
        $translation['j'] = (int) $translation['d'];
        $translation['n'] = (int) $translation['m'];

        $pattern = '#(\w{1,})([\s\/\,\.-]{1,})(\w{1,})([\s\/\,\.-]{1,})(\w{1,})#';
        if (preg_match($pattern, $format, $matches))
        {
            $formated = $translation[$matches[1]] . $matches[2] . $translation[$matches[3]] . $matches[4] . $translation[$matches[5]];
        }   
    
        return $formated;
    }
    

    /**
     * transform a date into a timestamp
     */
    public static function strToTime( $date ) 
    {
    	date_default_timezone_set('GMT');
    	return strtotime( $date );
    }


    public static function showWeekDays($display = 'calendar')
    {
        $weekdays = array(
            JText::_("COM_EASYAPPOINTMENT_SUNDAY", true),
            JText::_("COM_EASYAPPOINTMENT_MONDAY", true),
            JText::_("COM_EASYAPPOINTMENT_TUESDAY", true),
            JText::_("COM_EASYAPPOINTMENT_WEDNESDAY", true),
            JText::_("COM_EASYAPPOINTMENT_THURSDAY", true), 
            JText::_("COM_EASYAPPOINTMENT_FRIDAY", true),
            JText::_("COM_EASYAPPOINTMENT_SATURDAY", true)
        );
        if ($display == 'calendar')
        {
            $final = implode("','", $weekdays);
            $final = "'" . $final . "'";
        } 
        else
        {
            $final = $months;
        }

        return $final;
    }
	


    public static function showMonths($display = 'calendar')
    {
        $months = array(
            JText::_("COM_EASYAPPOINTMENT_JANUARY", true),
            JText::_("COM_EASYAPPOINTMENT_FEBRUARY", true),
            JText::_("COM_EASYAPPOINTMENT_MARCH", true),
            JText::_("COM_EASYAPPOINTMENT_APRIL", true),
            JText::_("COM_EASYAPPOINTMENT_MAY", true),
            JText::_("COM_EASYAPPOINTMENT_JUNE", true),
            JText::_("COM_EASYAPPOINTMENT_JULY", true),
            JText::_("COM_EASYAPPOINTMENT_AUGUST", true),
            JText::_("COM_EASYAPPOINTMENT_SEPTEMBER", true),
            JText::_("COM_EASYAPPOINTMENT_OCTOBER", true),
            JText::_("COM_EASYAPPOINTMENT_NOVEMBER", true),
            JText::_("COM_EASYAPPOINTMENT_DECEMBER", true)
        );
        if ($display == 'calendar')
        {
            $final = implode("','", $months);
            $final = "'" . $final . "'";
        } 
        else
        {
            $final = $months;
        }

        return $final;
    }


}

?>
