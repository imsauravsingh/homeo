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

class JFormFieldConsultonline extends JFormField
{

	public function getInput()
	{
    $user = MedialStaff::getInstance();
		$consult_online = $user->getParams()->get('consult_online');
/*    echo "<pre>****************************";
    print_r($home_visit);
    die;
*/
    $html =$this->getEnable($consult_online);

		return $html;
	}

  public function getEnable($consult_online){

    $enable ='';
    $disable ='selected="selected"';
    if($consult_online->enable){
      $enable='selected="selected"';
      $disable='';
    }else{
      $disable ='selected="selected"';
      $enable ='';
    }

    $html ='<div class="controls cold-md-6">';
    $html .='<label>Enable:</label>';
    $html .='<select id="jform_consult_online__enable" name="jform[consult_online][enable]" class="input-sm">';
    $html .='<option value="0" '.$disable.'>No</option>';
    $html .='<option value="1" '.$enable.'>Yes</option>';
    $html .='</select></div>';

    return $html;
  }


}
