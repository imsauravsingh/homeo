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

class JFormFieldClinicname extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$book_appointment = $user->getParams()->get('book_appointment');
/*    echo "<pre>****************************";
    print_r($home_visit);
    die;
*/
    $html =$this->getClinicName($book_appointment);

		return $html;
	}

  public function getClinicName($book_appointment){

    if($book_appointment->clinic_name) $clinic_name = $book_appointment->clinic_name;

    $html ='';
    $html .= '<input type="text" name="jform[book_appointment][clinic_name]" id="jform_book_appointment__clinic_name" value="'.$clinic_name.'" class="input-sm" placeholder="Clinic name">';

    return $html;
  }


}
