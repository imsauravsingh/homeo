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

class JFormFieldOnlinevideo extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$consult_online = $user->getParams()->get('consult_online');
/*    echo "<pre>****************************";
    print_r($consult_online);
    die;
*/
		$html = '';
    $html .=$this->getVideoEnable($consult_online);
    $html .=$this->getVideoFee($consult_online);
    $html .=$this->getVideoDuration($consult_online);
    $html .=$this->getVideoAvailability($consult_online);

		return $html;
	}

  public function getVideoDuration($consult_online)
	{
    $video_duration = 7;
    $video_duration_type0 = 'selected="selected"';
    $video_duration_type1 = '';
    $video_duration_type2 = '';

    if($consult_online->video_duration) $video_duration = $consult_online->video_duration;

    if($consult_online->video_duration_type==0){
      $video_duration_type0 = 'selected="selected"';
      $video_duration_type1 = '';
      $video_duration_type2 = '';
    }elseif($consult_online->video_duration_type==1){
      $video_duration_type1 = 'selected="selected"';
      $video_duration_type0 = '';
      $video_duration_type2 = '';
    }elseif($consult_online->video_duration_type==2){
      $video_duration_type2 = 'selected="selected"';
      $video_duration_type0 = '';
      $video_duration_type1 = '';
    }

		$html = '';
		$html .= '<div class="cold-md-6">';
    $html .='<label>Duration:</label>';
    $html .= '<input type="number" name="jform[consult_online][video_duration]" id="jform_consult_online__video_duration" value="'.$video_duration.'" class="input-sm" placeholder="Only number">';
    $html .= '<select id="jform_consult_online__video_duration_type" name="jform[consult_online][video_duration_type]" class="input-sm">';
	  $html .= '<option value="0" '.$video_duration_type0.'>Day</option>';
	  $html .= '<option value="1" '.$video_duration_type1.'>Week</option>';
	  $html .= '<option value="2" '.$video_duration_type2.'>Month</option>';
    $html .= '</select></div>';
		return $html;
	}

  public function getVideoEnable($consult_online){

    $enable ='';
    $disable ='selected="selected"';
    if($consult_online->video_enable){
      $enable='selected="selected"';
      $disable='';
    }else{
      $disable ='selected="selected"';
      $enable ='';
    }

    $html ='<div class="controls cold-md-6">';
    $html .='<label>Enable:</label>';
    $html .='<select id="jform_consult_online__video_enable" name="jform[consult_online][video_enable]" class="input-sm">';
    $html .='<option value="0" '.$disable.'>No</option>';
    $html .='<option value="1" '.$enable.'>Yes</option>';
    $html .='</select></div>';

    return $html;
  }
  public function getVideoFee($consult_online){

    $video_fee="700";
    if($consult_online->video_fee) $video_fee = $consult_online->video_fee;

    $html ='<div class="controls cold-md-6">';
    $html .='<label>Fee:</label>';
    $html .= '<input type="number" name="jform[consult_online][video_fee]" id="jform_consult_online__video_fee" value="'.$video_fee.'" class="input-sm" placeholder="Video Fee">Rs';
    $html .='</div>';

    return $html;
  }

  public function getVideoAvailability($consult_online)
	{
    $video_availability_from = 12;
    if($consult_online->video_availability_from){
      $video_availability_from = $consult_online->video_availability_from;
    }

    if($consult_online->video_availability_from_type=='am'){
      $video_availability_from_typeAM = 'selected="selected"';
      $video_availability_from_typePM = '';
    }else{
      $video_availability_from_typeAM = '';
      $video_availability_from_typePM = 'selected="selected"';
    }

    $video_availability_to = 12;
    if($consult_online->video_availability_to){
      $video_availability_to = $consult_online->video_availability_to;
    }

    if($consult_online->video_availability_to_type=='am'){
      $video_availability_to_typeAM = 'selected="selected"';
      $video_availability_to_typePM = '';
    }else{
      $video_availability_to_typeAM = '';
      $video_availability_to_typePM = 'selected="selected"';
    }

		$html = '';
					$html .= '
          <div class="cold-md-6">
          <label>'.JText::_('COM_EASYAPPOINTMENT_CONSULT_ONLINE_DURATION_AVAILABILITY').'</label>
          <label>From:</label>
          <select name="jform[consult_online][video_availability_from]" id="jform_consult_online__video_availability_from" class="input-sm">';

for($i=1; $i<=12; $i++){
  if($video_availability_from==$i){
    $html .='<option value="'.$i.'" selected="selected">'.$i.'</option>';
  }else{
    $html .='<option value="'.$i.'">'.$i.'</option>';
  }
}
          $html .='</select>
          <select id="jform_consult_online__video_availability_from_type" name="jform[consult_online][video_availability_from_type]" class="input-sm">
          	<option value="am" '.$video_availability_from_typeAM.'>AM</option>
          	<option value="pm" '.$video_availability_from_typePM.'>PM</option>
          </select>
</div>

<div class="cold-md-6">
<label>To:</label>
<select name="jform[consult_online][video_availability_to]" id="jform_consult_online__video_availability_to" class="input-sm">';

for($i=1; $i<=12; $i++){
  if($video_availability_to==$i){
    $html .='<option value="'.$i.'" selected="selected">'.$i.'</option>';
  }else{
    $html .='<option value="'.$i.'">'.$i.'</option>';
  }
}
$html .='</select>
            <select id="jform_consult_online__video_availability_to_type" name="jform[consult_online][video_availability_to_type]" class="input-sm">
            <option value="am" '.$video_availability_to_typeAM.'>AM</option>
          	<option value="pm" '.$video_availability_to_typePM.'>PM</option>
</select>
</div>';
		return $html;
	}

}
