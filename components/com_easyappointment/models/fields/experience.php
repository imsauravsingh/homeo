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

    $html ='<div class="main_experience_group">';
    $html .= '<div class="experience" id="div_experience1"><input type="text" id="jform_profile_display__experience1" name="jform[profile_display][experience1]" value="'.$experience1.'" class="input-sm" placeholder="Experience"></div>';
    
    for($i=2; $i<=20; $i++){
        $experience ="";

        $awardz ='style="display:none;"'; if(!empty($data->{experience.$i})){ $experience  = $data->{experience.$i}; $awardz = ''; }

        $html .= '<div class="experience" '.$awardz.' id="div_experience'.$i.'"><input type="text" id="jform_profile_display__experience'.$i.'" name="jform[profile_display][experience'.$i.']" value="'.$experience.'" class="input-sm" placeholder="Experience"><span class="remove" onclick="javascript:experienceRemove('.$i.')">Remove</span></div>';
    }

    $html .= '<span id="experience_addmore" onclick="javascript:experienceAddMore();">Add More+</span>';

    $html .='</div>';

    return $html;
  }



}
