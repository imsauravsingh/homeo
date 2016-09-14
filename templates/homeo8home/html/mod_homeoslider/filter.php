<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// searchOnlineDoctors

$doc = JFactory::getDocument();

// Add styles
$style = '.moduletable {'
        . 'background: #ffffff!important;'
        . '}';
$doc->addStyleDeclaration($style);
// Add Javascript
$modhomeoScript = '
var $ =jQuery.noConflict();
$(window).ready(function() {

	$("#searchOnlineDoctors, #searchAppointmentDoctors, #searchHomevisitDoctors").on("click",function(){

var city = parseInt($(this).parent().parent().parent().find("select[name=\'city\']").val());
var locality = parseInt($(this).parent().parent().parent().find("select[name=\'locality\']").val());
var speciality = parseInt($(this).parent().parent().parent().find("select[name=\'speciality\']").val());
//var city = parseInt($("select[name=\'city\']").val());
//var locality =parseInt($("select[name=\'locality\']").val());
//var speciality =parseInt($("select[name=\'speciality\']").val());
if(isNaN(city)){
	alert("Please select city!");
	$("select[name=\'city\']").focus();
	return false;
}else{
	var searchredirecturl = baseurl;
  if(isNaN(speciality)) speciality = 0;
	if(isNaN(locality)) locality = 0;
	if(isNaN(city)) city = 0;

  if(speciality!=0){
    searchredirecturl +="index.php?option=com_easyappointment&view=browse&category="+speciality+"&Itemid=501&speciality="+speciality+"&city="+city+"&locality="+locality;
	}else{
		searchredirecturl +="index.php?option=com_easyappointment&view=browse&category=0&Itemid=501&search_type=1&speciality="+speciality+"&city="+city+"&locality="+locality;
	}
	window.location.href=searchredirecturl;
}
//console.log(baseurl);


							 });
	});';

$city_id   = JRequest::getVar('city');
$speciality_id   = JRequest::getVar('speciality');
$locality_id   = JRequest::getVar('locality');

$doc->addScriptDeclaration($modhomeoScript);

$city = '<select class="form-control  form" name="city" placeholder="City" required>';
$city .=	'<option>-- Select City --</option>';
$city .=	'<option value="1" selected> Delhi (NCR)</option>';
$city .= '</select>';

$locality = '<select class="form-control  form" name="locality" placeholder="Locality">';
$locality .=	'<option>-- Select Locality --</option>';
$locality .=	'<option>No records!</option>';
$locality .= '</select>';

$speciality = '<select class="form-control  form" name="speciality" placeholder="Speciality">';
 if(count($services)){
$speciality .=	'<option>-- Select Services --</option>';
	foreach($services as $service){
    if($speciality_id==$service->id){
      $speciality .=	'<option value="'.$service->id.'" selected>'.ucfirst($service->name).'</option>';
    }else{
      $speciality .=	'<option value="'.$service->id.'">'.ucfirst($service->name).'</option>';
    }
 }}else{
$speciality .=	'<option>No records!</option>';
  }
$speciality .= '</select>';

?>


<div class="row">
	<!--<jdoc:include type="modules" name="position-2" style="none" /> -->
			<div id="filter" >

				<div>
										<div class=" col-md-12 col-xs-12">
												<?php echo $city; ?>
												<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
										</div>
										<div class=" col-md-12 col-xs-12">
												<?php echo $locality; ?>
												<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
										</div>
										<div class=" col-md-12 col-xs-12">
												<?php echo $speciality; ?>
												<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
										</div>
										<div class=" col-md-12 col-xs-12">
												<button type="button" id="searchOnlineDoctors" class="submit button">SEARCH</button>
												<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
										</div>
									</div>

		</div>
	</div>
