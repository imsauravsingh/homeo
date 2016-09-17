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
    	$path = JPATH_COMPONENT . '/default_menu.php';
    	require_once($path);
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
     * transform an 24 hour format (HH:ii) to seconds
     * opposite of showTime
     */
    public static function hourToTime($hour)
    {
        if (strpos($hour, ':') === false)
        {
            return 0;
        }

        $parts = explode(':', $hour);
        return $parts[0] * 3600 + $parts[1] * 60;
    }


    /**
     * display date in the chosen format
     * 
     * @param  [type] $date   [date in YYYY-mm-dd format]
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
    public static function strToTime($date) 
    {
    	date_default_timezone_set('GMT');
    	return strtotime($date);
    }


    /**
     * get formated list of days to be used in the calendar js
     * if we need it as an array, use other value for $display
     */
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
            $final = $weekdays;
        }

        return $final;
    }
	

    /**
     * get formated list of months to be used in the calendar js
     * if we need it as an array, use other value for $display
     */
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


    /**
     * display progress during appointment process in the front-end area
     * if confirmation during process is not required, steps = 2 else steps = 3
     */
    public static function showFormSteps($step = 'information', $confirm = 1)
    {
        $html = '<div class="row steps">';
        $html .= '<div class="col-md-12">';
        $html .= '<ul class="booking-steps">';
        $html .= $step == 'information' ? '<li class="step1 active">' : '<li class="step1">';
        $html .= JText::_('COM_EASYAPPOINTMENT_BOOKING_STEP_1').'</li>';
        if ($confirm == 1) 
        {
            $html .= $step == 'confirmation' ? '<li class="step2 active">' : '<li class="step2">';
            $html .= JText::_('COM_EASYAPPOINTMENT_BOOKING_STEP_2').'</li>';
        }
        $html .= $step == 'finished' ? '<li class="step3 active">' : '<li class="step3">';
        $html .= JText::_('COM_EASYAPPOINTMENT_BOOKING_STEP_3').'</li>';
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }


    /**
     * build the html table that display a staff calendar
     * 
     * @param [$user] [object] [MedialStaff user instance, selected user]
     * @param [$service] [object] [MedialService instance, selected service]
     * @param [$calendar] [object] [MedialCalendar instance, calendar data]
     *
     * @return [string] [html code to display the calendar for the user & service]
     */
    public static function buildCalendar($user,$service,$calendar) 
    {    
        $html = '';
        $days = $calendar->getDays();

        $html .= '<table class="table table-bordered table-condensed">';
        $html .= '<thead>';
        $html .= '<tr class="days-of-week">';
        foreach ($days as $key=>$day) 
        {
            $html .= '<th class="cell' . $key%2 . '">' . $day->name . '</th>';
        } 
        $html .= '</tr>';
        $html .= '<tr class="names-row">';
        foreach ($days as $key=>$day) 
        {
            $html .= '<th width="14%" class="cell' . $key%2 . '">' . self::showDate($day->date, $user->getParams()->get('date_format')) .'</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';

        $html .= '<tbody>';
        $i = 0; while($i < $calendar->max_count_hours) 
        { 
            $html .= '<tr class="offset-top">';
            foreach ($days as $key=>$day) 
            { 
                if ($day->working) 
                { 
                    // create calendar node info
                    $node = new stdclass;
                    $node->appointmentDate = $day->date;
                    $node->startingTime = key($days[$key]->hours);
                    $node->endingTime = $node->startingTime + $calendar->timeframe;
                    $node->service = $service->id;
                    $node->staff = $user->id; 
                    $node->user = $user->id; 
                    $data = base64_encode(json_encode($node));

                    $html .= '<td class="cell' . $key%2 . '">';
                    $html .= MedialValidator::isNodeFree($node->startingTime, $node->endingTime, $days[$key]->busy) ? 
                                '<a class="free" href="' . JRoute::_('index.php?option=com_easyappointment&task=user.information&d=' . $data . '&' . JFactory::getSession()->getFormToken() . '=1') . '">'.current($day->hours).'</a>' : 
                                '<s class="busy">'.current($day->hours).'</s>';
                    $html .= '</td>';
                    unset($days[$key]->hours[$node->startingTime]); 
                } 
                else 
                {                     
                    $html .= '<td class="cell' . $key%2 . '"></td>';
                } 
            } 
            $html .= '</tr>';
            $i++; 
        } 
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }


}

?>
