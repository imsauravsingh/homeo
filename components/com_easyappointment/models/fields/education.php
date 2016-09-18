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

class JFormFieldEducation extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$data = $user->getParams()->get('profile_display');
    $html =$this->getEducations($data);
		return $html;
	}

  public function getEducations($data){

    if($data->education1) $education1 = $data->education1;
    if($data->education2) $education2 = $data->education2;
    if($data->education3) $education3 = $data->education3;
    if($data->education4) $education4 = $data->education4;
    if($data->education5) $education5 = $data->education5;
    if($data->education6) $education6 = $data->education6;
    if($data->education7) $education7 = $data->education7;
    if($data->education8) $education8 = $data->education8;
    if($data->education9) $education9 = $data->education9;
    if($data->education10) $education10 = $data->education10;

    $html ='';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education1" name="jform[profile_display][education1]" value="'.$education1.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education2" name="jform[profile_display][education2]" value="'.$education2.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education3" name="jform[profile_display][education3]" value="'.$education3.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education4" name="jform[profile_display][education4]" value="'.$education4.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education5" name="jform[profile_display][education5]" value="'.$education5.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education6" name="jform[profile_display][education6]" value="'.$education6.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education7" name="jform[profile_display][education7]" value="'.$education7.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education8" name="jform[profile_display][education8]" value="'.$education8.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education9" name="jform[profile_display][education9]" value="'.$education9.'" class="input-sm" placeholder="education"></div>';
    $html .= '<div class="education"><input type="text" id="jform_profile_display__education10" name="jform[profile_display][education10]" value="'.$education10.'" class="input-sm" placeholder="education"></div>';

    return $html;
  }



}
