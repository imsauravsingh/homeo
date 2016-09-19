<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldRegistration extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$data = $user->getParams()->get('profile_display');
/*    echo "<pre>****************************";
    print_r($home_visit);
    die;
*/
    $html =$this->getRegistrationDetails($data);

		return $html;
	}

  public function getRegistrationDetails($data){

    if($book_appointment->clinic_name) $clinic_name = $book_appointment->clinic_name;

    $html ='<div>';
    $html .= '<label>Registration No.</label><div><input type="text" name="jform[profile_display][]" id="jform_book_appointment__clinic_name" value="'.$clinic_name.'" class="input-sm" placeholder="Clinic name"></div>';
    $html .= '</div>';

    return $html;
  }


}
