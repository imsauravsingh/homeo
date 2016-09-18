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

class JFormFieldHomevisit extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$home_visit = $user->getParams()->get('home_visit');
/*    echo "<pre>****************************";
    print_r($home_visit);
    die;
*/
		$html = '';
    $html .=$this->getHomevisitEnable($home_visit);
    $html .=$this->getHomevisitFee($home_visit);
    $html .=$this->getHomevisitDuration($home_visit);
    $html .=$this->getHomevisitAvailability($home_visit);

		return $html;
	}

  public function getHomevisitDuration($home_visit)
	{
    $homevisit_duration = 7;
    $homevisit_duration_type0 = 'selected="selected"';
    $homevisit_duration_type1 = '';
    $homevisit_duration_type2 = '';

    if($home_visit->homevisit_duration) $homevisit_duration = $home_visit->homevisit_duration;

    if($home_visit->homevisit_duration_type==0){
      $homevisit_duration_type0 = 'selected="selected"';
      $homevisit_duration_type1 = '';
      $homevisit_duration_type2 = '';
    }elseif($home_visit->homevisit_duration_type==1){
      $homevisit_duration_type1 = 'selected="selected"';
      $homevisit_duration_type0 = '';
      $homevisit_duration_type2 = '';
    }elseif($home_visit->homevisit_duration_type==2){
      $homevisit_duration_type2 = 'selected="selected"';
      $homevisit_duration_type0 = '';
      $homevisit_duration_type1 = '';
    }

		$html = '';
		$html .= '<div class="cold-md-6">';
    $html .='<label>Duration:</label>';
    $html .= '<input type="number" name="jform[home_visit][homevisit_duration]" id="jform_home_visit__homevisit_duration" value="'.$homevisit_duration.'" class="input-sm" placeholder="Only number">';
    $html .= '<select id="jform_home_visit__homevisit_duration_type" name="jform[home_visit][homevisit_duration_type]" class="input-sm">';
	  $html .= '<option value="0" '.$homevisit_duration_type0.'>Day</option>';
	  $html .= '<option value="1" '.$homevisit_duration_type1.'>Week</option>';
	  $html .= '<option value="2" '.$homevisit_duration_type2.'>Month</option>';
    $html .= '</select></div>';
		return $html;
	}

  public function getHomevisitEnable($home_visit){

    $enable ='';
    $disable ='selected="selected"';
    if($home_visit->homevisit_enable){
      $enable='selected="selected"';
      $disable='';
    }else{
      $disable ='selected="selected"';
      $enable ='';
    }

    $html ='<div class="controls cold-md-6">';
    $html .='<label>Enable:</label>';
    $html .='<select id="jform_home_visit__homevisit_enable" name="jform[home_visit][homevisit_enable]" class="input-sm">';
    $html .='<option value="0" '.$disable.'>No</option>';
    $html .='<option value="1" '.$enable.'>Yes</option>';
    $html .='</select></div>';

    return $html;
  }

  public function getHomevisitFee($home_visit){

    $homevisit_fee="700";
    if($home_visit->homevisit_fee) $homevisit_fee = $home_visit->homevisit_fee;

    $html ='<div class="controls cold-md-6">';
    $html .='<label>Fee:</label>';
    $html .= '<input type="number" name="jform[home_visit][homevisit_fee]" id="jform_home_visit__homevisit_fee" value="'.$homevisit_fee.'" class="input-sm" placeholder="homevisit Fee">Rs';
    $html .='</div>';

    return $html;
  }

  public function getHomevisitAvailability($home_visit)
	{
    $homevisit_availability_from = 12;
    if($home_visit->homevisit_availability_from){
      $homevisit_availability_from = $home_visit->homevisit_availability_from;
    }

    if($home_visit->homevisit_availability_from_type=='am'){
      $homevisit_availability_from_typeAM = 'selected="selected"';
      $homevisit_availability_from_typePM = '';
    }else{
      $homevisit_availability_from_typeAM = '';
      $homevisit_availability_from_typePM = 'selected="selected"';
    }

    $homevisit_availability_to = 12;
    if($home_visit->homevisit_availability_to){
      $homevisit_availability_to = $home_visit->homevisit_availability_to;
    }

    if($home_visit->homevisit_availability_to_type=='am'){
      $homevisit_availability_to_typeAM = 'selected="selected"';
      $homevisit_availability_to_typePM = '';
    }else{
      $homevisit_availability_to_typeAM = '';
      $homevisit_availability_to_typePM = 'selected="selected"';
    }

		$html = '';
					$html .= '
          <div class="cold-md-6">
          <label>'.JText::_('COM_EASYAPPOINTMENT_HOME_VISIT_DURATION_AVAILABILITY').'</label>
          <label>From:</label>
          <select name="jform[home_visit][homevisit_availability_from]" id="jform_home_visit__homevisit_availability_from" class="input-sm">';

for($i=1; $i<=12; $i++){
  if($homevisit_availability_from==$i){
    $html .='<option value="'.$i.'" selected="selected">'.$i.'</option>';
  }else{
    $html .='<option value="'.$i.'">'.$i.'</option>';
  }
}
          $html .='</select>
          <select id="jform_home_visit__homevisit_availability_from_type" name="jform[home_visit][homevisit_availability_from_type]" class="input-sm">
          	<option value="am" '.$homevisit_availability_from_typeAM.'>AM</option>
          	<option value="pm" '.$homevisit_availability_from_typePM.'>PM</option>
          </select>
</div>

<div class="cold-md-6">
<label>To:</label>
<select name="jform[home_visit][homevisit_availability_to]" id="jform_home_visit__homevisit_availability_to" class="input-sm">';

for($i=1; $i<=12; $i++){
  if($homevisit_availability_to==$i){
    $html .='<option value="'.$i.'" selected="selected">'.$i.'</option>';
  }else{
    $html .='<option value="'.$i.'">'.$i.'</option>';
  }
}
$html .='</select>
            <select id="jform_home_visit__homevisit_availability_to_type" name="jform[home_visit][homevisit_availability_to_type]" class="input-sm">
            <option value="am" '.$homevisit_availability_to_typeAM.'>AM</option>
          	<option value="pm" '.$homevisit_availability_to_typePM.'>PM</option>
</select>
</div>';
		return $html;
	}

}
