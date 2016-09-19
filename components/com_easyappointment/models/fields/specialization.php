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

class JFormFieldSpecialization extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$data = $user->getParams()->get('profile_display');
    $html =$this->getSpecialization($data);
		return $html;
	}

  public function getSpecialization($data){

    if($data->specialization1) $specialization1 = $data->specialization1;
    if($data->specialization2) $specialization2 = $data->specialization2;
    if($data->specialization3) $specialization3 = $data->specialization3;
    if($data->specialization4) $specialization4 = $data->specialization4;
    if($data->specialization5) $specialization5 = $data->specialization5;
    if($data->specialization6) $specialization6 = $data->specialization6;
    if($data->specialization7) $specialization7 = $data->specialization7;
    if($data->specialization8) $specialization8 = $data->specialization8;
    if($data->specialization9) $specialization9 = $data->specialization9;
    if($data->specialization10) $specialization10 = $data->specialization10;

    $html ='';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization1" name="jform[profile_display][specialization1]" value="'.$specialization1.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization2" name="jform[profile_display][specialization2]" value="'.$specialization2.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization3" name="jform[profile_display][specialization3]" value="'.$specialization3.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization4" name="jform[profile_display][specialization4]" value="'.$specialization4.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization5" name="jform[profile_display][specialization5]" value="'.$specialization5.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization6" name="jform[profile_display][specialization6]" value="'.$specialization6.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization7" name="jform[profile_display][specialization7]" value="'.$specialization7.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization8" name="jform[profile_display][specialization8]" value="'.$specialization8.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization9" name="jform[profile_display][specialization9]" value="'.$specialization9.'" class="input-sm" placeholder="Specialization"></div>';
    $html .= '<div class="specialization"><input type="text" id="jform_profile_display__specialization10" name="jform[profile_display][specialization10]" value="'.$specialization10.'" class="input-sm" placeholder="Specialization"></div>';

    return $html;
  }



}
