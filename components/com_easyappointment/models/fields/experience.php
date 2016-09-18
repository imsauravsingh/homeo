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

class JFormFieldExperience extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$data = $user->getParams()->get('profile_display');
    $html =$this->getExperience($data);
		return $html;
	}

  public function getExperience($data){

    if($data->experience1) $experience1 = $data->experience1;
    if($data->experience2) $experience2 = $data->experience2;
    if($data->experience3) $experience3 = $data->experience3;
    if($data->experience4) $experience4 = $data->experience4;
    if($data->experience5) $experience5 = $data->experience5;
    if($data->experience6) $experience6 = $data->experience6;
    if($data->experience7) $experience7 = $data->experience7;
    if($data->experience8) $experience8 = $data->experience8;
    if($data->experience9) $experience9 = $data->experience9;
    if($data->experience10) $experience10 = $data->experience10;

    $html ='';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience1" name="jform[profile_display][experience1]" value="'.$experience1.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience2" name="jform[profile_display][experience2]" value="'.$experience2.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience3" name="jform[profile_display][experience3]" value="'.$experience3.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience4" name="jform[profile_display][experience4]" value="'.$experience4.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience5" name="jform[profile_display][experience5]" value="'.$experience5.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience6" name="jform[profile_display][experience6]" value="'.$experience6.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience7" name="jform[profile_display][experience7]" value="'.$experience7.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience8" name="jform[profile_display][experience8]" value="'.$experience8.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience9" name="jform[profile_display][experience9]" value="'.$experience9.'" class="input-sm" placeholder="experience"></div>';
    $html .= '<div class="experience"><input type="text" id="jform_profile_display__experience10" name="jform[profile_display][experience10]" value="'.$experience10.'" class="input-sm" placeholder="experience"></div>';

    return $html;
  }



}
