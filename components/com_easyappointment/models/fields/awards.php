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

    $html ='<div class="main_awards_group">';
    $html .= '<div class="awards" id="div_awards1"><input type="text" id="jform_profile_display__awards1" name="jform[profile_display][awards1]" value="'.$awards1.'" class="input-sm" placeholder="Awards"></div>';
    
    for($i=2; $i<=20; $i++){
        $awards ="";

        $awardz ='style="display:none;"'; if(!empty($data->{awards.$i})){ $awards  = $data->{awards.$i}; $awardz = ''; }

        $html .= '<div class="awards" '.$awardz.' id="div_awards'.$i.'"><input type="text" id="jform_profile_display__awards'.$i.'" name="jform[profile_display][awards'.$i.']" value="'.$awards.'" class="input-sm" placeholder="Awards"><span class="remove" onclick="javascript:awardsRemove('.$i.')">Remove</span></div>';
    }

    $html .= '<span id="awards_addmore" onclick="javascript:awardsAddMore();">Add More+</span>';

    $html .='</div>';

    return $html;
  }



}
