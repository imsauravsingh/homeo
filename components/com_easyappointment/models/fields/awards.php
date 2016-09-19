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

class JFormFieldAwards extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$data = $user->getParams()->get('profile_display');
    $html =$this->getAwards($data);
		return $html;
	}

  public function getAwards($data){

    if($data->awards1) $awards1 = $data->awards1;
    if($data->awards2) $awards2 = $data->awards2;
    if($data->awards3) $awards3 = $data->awards3;
    if($data->awards4) $awards4 = $data->awards4;
    if($data->awards5) $awards5 = $data->awards5;
    if($data->awards6) $awards6 = $data->awards6;
    if($data->awards7) $awards7 = $data->awards7;
    if($data->awards8) $awards8 = $data->awards8;
    if($data->awards9) $awards9 = $data->awards9;
    if($data->awards10) $awards10 = $data->awards10;

    $html ='';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards1" name="jform[profile_display][awards1]" value="'.$awards1.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards2" name="jform[profile_display][awards2]" value="'.$awards2.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards3" name="jform[profile_display][awards3]" value="'.$awards3.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards4" name="jform[profile_display][awards4]" value="'.$awards4.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards5" name="jform[profile_display][awards5]" value="'.$awards5.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards6" name="jform[profile_display][awards6]" value="'.$awards6.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards7" name="jform[profile_display][awards7]" value="'.$awards7.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards8" name="jform[profile_display][awards8]" value="'.$awards8.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards9" name="jform[profile_display][awards9]" value="'.$awards9.'" class="input-sm" placeholder="awards"></div>';
    $html .= '<div class="awards"><input type="text" id="jform_profile_display__awards10" name="jform[profile_display][awards10]" value="'.$awards10.'" class="input-sm" placeholder="awards"></div>';

    return $html;
  }



}
