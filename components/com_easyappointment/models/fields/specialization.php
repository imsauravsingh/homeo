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

    $html ='<div class="main_specialization_group">';
    $html .= '<div class="specialization" id="div_specialization1"><input type="text" id="jform_profile_display__specialization1" name="jform[profile_display][specialization1]" value="'.$specialization1.'" class="input-sm" placeholder="Specialization"></div>';
    
    for($i=2; $i<=20; $i++){
        $specialization ="";

        $speclz ='style="display:none;"'; if(!empty($data->{specialization.$i})){ $specialization  = $data->{specialization.$i}; $speclz = ''; }

        $html .= '<div class="specialization" '.$speclz.' id="div_specialization'.$i.'"><input type="text" id="jform_profile_display__specialization'.$i.'" name="jform[profile_display][specialization'.$i.']" value="'.$specialization .'" class="input-sm" placeholder="Specialization"><span class="remove" onclick="javascript:specializationRemove('.$i.')">Remove</span></div>';
    }

    $html .= '<span id="speclztn_addmore" onclick="javascript:specializationAddMore();">Add More+</span>';
    
    $html .='</div>';
    return $html;
  }



}
