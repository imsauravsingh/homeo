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

class JFormFieldClinicaddress extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$book_appointment = $user->getParams()->get('book_appointment');
/*    echo "<pre>****************************";
    print_r($home_visit);
    die;
*/
    $html =$this->getClinicAddress($book_appointment);

		return $html;
	}

  public function getClinicAddress($book_appointment){

    if($book_appointment->clinic_address) $clinic_address = $book_appointment->clinic_address;

    $html ='';
    $html .= '<textarea name="jform[book_appointment][clinic_address]" placeholder="Clinic address" id="jform_book_appointment__clinic_address">'.$clinic_address.'</textarea>';

    return $html;
  }


}
