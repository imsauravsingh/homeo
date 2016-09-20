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

    $html ='<div class="main_education_group">';
    $html .= '<div class="education" id="div_education1"><input type="text" id="jform_profile_display__education1" name="jform[profile_display][education1]" value="'.$education1.'" class="input-sm" placeholder="Education"></div>';
    
    for($i=2; $i<=20; $i++){
        $education ="";

        $awardz ='style="display:none;"'; if(!empty($data->{education.$i})){ $education  = $data->{education.$i}; $awardz = ''; }

        $html .= '<div class="education" '.$awardz.' id="div_education'.$i.'"><input type="text" id="jform_profile_display__education'.$i.'" name="jform[profile_display][education'.$i.']" value="'.$education.'" class="input-sm" placeholder="Education"><span class="remove" onclick="javascript:educationRemove('.$i.')">Remove</span></div>';
    }

    $html .= '<span id="education_addmore" onclick="javascript:educationAddMore();">Add More+</span>';

    $html .='</div>';

    return $html;
  }

}
