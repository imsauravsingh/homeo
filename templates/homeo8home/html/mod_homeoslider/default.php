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

// Add Javascript
$modhomeoScript = '
jQuery(window).ready(function() {

	jQuery("#searchOnlineDoctors, #searchAppointmentDoctors, #searchHomevisitDoctors").on("click",function(){

var city = parseInt(jQuery(this).parent().parent().parent().find("select[name=\'city\']").val());
var locality = parseInt(jQuery(this).parent().parent().parent().find("select[name=\'locality\']").val());
var speciality = parseInt(jQuery(this).parent().parent().parent().find("select[name=\'speciality\']").val());
//var city = parseInt(jQuery("select[name=\'city\']").val());
//var locality =parseInt(jQuery("select[name=\'locality\']").val());
//var speciality =parseInt(jQuery("select[name=\'speciality\']").val());
var search_data_bytab = jQuery("input#search_data_bytab").val();

if(isNaN(city)){
	alert("Please select city!");
	jQuery("select[name=\'city\']").focus();
	return false;
}else{
	var searchredirecturl = baseurl;
	if(isNaN(speciality)) speciality = 0;
	if(isNaN(locality)) locality = 0;
	if(isNaN(city)) city = 0;

	if(speciality!=0){
		searchredirecturl +="index.php?option=com_easyappointment&view=browse&category="+speciality+"&Itemid=501&speciality="+speciality+"&city="+city+"&locality="+locality+"&search_data_bytab="+search_data_bytab;
	}else{
		searchredirecturl +="index.php?option=com_easyappointment&view=browse&category=0&Itemid=501&search_type=1&speciality="+speciality+"&city="+city+"&locality="+locality+"&search_data_bytab="+search_data_bytab;
	}
	window.location.href=searchredirecturl;
}
//console.log(baseurl);


							 });
	});';
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
$speciality .=	'<option value="'.$service->id.'">'.ucfirst($service->name).'</option>';
 }}else{
$speciality .=	'<option>No records!</option>';
  }
$speciality .= '</select>';

?>


<div class="row">
	<!--<jdoc:include type="modules" name="position-2" style="none" /> -->
			<div id="main_bg_banner" class="banner_tab0_img">
		<div class="container">
                <div class="row">
			         <div class="col-lg-8 col-lg-offset-2 col-md-offset-2 col-md-8 col-xs-12">
                <div class=" Tabs">
				<div class="active">
					<ul class="nav nav-pills" id="banner_li">
						<li class="active" data-banner="banner_tab0_img" data-searchbind="consult_online"><a data-toggle="pill" href="#banner_tab0">Consult Online</a></li>
						<li data-banner="banner_tab1_img" data-searchbind="ask_question"><a data-toggle="pill" href="#banner_tab1">Ask a Question</a></li>
						<li data-banner="banner_tab2_img" data-searchbind="book_appointment"><a data-toggle="pill" href="#banner_tab2">Book Appointment</a></li>
						<li data-banner="banner_tab3_img" data-searchbind="home_visit"><a data-toggle="pill" href="#banner_tab3">Home Visit</a></li>
						<input type="hidden" name="search_data_bytab" id="search_data_bytab" value="consult_online">
					</ul>

					<div class="tab-content homeo_services_content">
						<div id="banner_tab0" class="tab-pane fade in active">
								<div class="h3">Not able to Move ?</div>
								<div class="title">homeo8home,choose your doctor and consult online and get your problems assessed. </div>
								<div class="input">
									<div id="imaginary_container">
										<div class="form-group">
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $city; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
                                                <div class="clr"></div>
											</div>
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $locality; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $speciality; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-2 col-sm-2 col-xs-12 icon-addon addon-md">
												<div class="row">
													<button type="button" id="searchOnlineDoctors" class="submit button">SEARCH</button>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
                                            <div class="clearfix"></div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="step">
									<div class="row">
										<div class="col-md-4 col-xs-4">
											<img src="<?php echo JURI::base() . 'templates/homeo8home/images/s.no1.png'; ?>" alt="1."/>
											<img src="<?php echo JURI::base() . 'templates/homeo8home/images/doctor.png'; ?>" alt="doctor" class="icons"/>
											<p>CHOOSE A DOCTOR</p>
										</div>
										<div class="col-md-4 col-xs-4">
											<img src="<?php echo JURI::base() . 'templates/homeo8home/images/s.no2.png'; ?>" alt="1."/>
											<img src="<?php echo JURI::base() . 'templates/homeo8home/images/money.png'; ?>" alt="doctor" class="icons"/>
											<p>PAY CONSULTATION FEE</p>
										</div>
										<div class="col-md-4 col-xs-4 ">
											<img src="<?php echo JURI::base() . 'templates/homeo8home/images/s.no3.png'; ?>" alt="1."/>
											<img src="<?php echo JURI::base() . 'templates/homeo8home/images/msg.png'; ?>" alt="doctor" class="icons"/>
											<p>TALK TO THE DOCTOR</p>
										</div>
									</div>
								</div>
						</div>
						<div id="banner_tab1" class="tab-pane fade">
								<div class="h3">Looking for an answer ?</div>
								<div class="title">Ask questions from expert doctors and also get free health tips and advice on your health.</div>
								<br>
								<div class="form-group">
									<label for="comment">Your Question :</label>
									<textarea class="form-control question_area" rows="3" id="comment"></textarea>
								</div>
								<div class="ask-button"><a href="#">Get your Answers</a></div>
								<div class="clearfix"></div>
								<div class="step30">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no1.png" alt="1."/>
											<img src="images/doctor.png" alt="doctor" class="icons"/>
											<p>Verified Doctors</p>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no2.png" alt="1."/>
											<img src="images/anonyms.png" alt="doctor" class="icons"/>
											<p>Remain Anonymous</p>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no3.png" alt="1."/>
											<img src="images/time.png" alt="doctor" class="icons"/>
											<p>Quick Responses 24-48 hours</p>
										</div>
									</div>
								</div>
						</div>
						<div id="banner_tab2" class="tab-pane fade">
							 <div class="h3">Sick of waiting in traffic and queues ?</div>
								<div class="title">Book your appointment online and save your time at no additional charges.</div>
								<div class="input">
									<div id="imaginary_container">
										<div class="form-group">
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $city; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $locality; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $speciality; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-2 col-sm-2 col-xs-12 icon-addon addon-md">
												<div class="row">
													<button type="button" id="searchAppointmentDoctors" class="submit button">SEARCH</button>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="step">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no1.png" alt="1."/>
											<img src="images/location.png" alt="doctor" class="icons"/>
											<p>Doctors in Delhi/NCR</p>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no2.png" alt="1."/>
											<img src="images/verified-patient.png" alt="doctor" class="icons"/>
											<p>Verified patient reviews</p>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no3.png" alt="1."/>
											<img src="images/appointments.png" alt="doctor" class="icons"/>
											<p>Appointments without hassle</p>
										</div>
									</div>
								</div>
						</div>
						<div id="banner_tab3" class="tab-pane fade">
								 <div class="h3">Meet a homeopathy doctor fast with Homeo8Home.</div>
								<div class="title"> India's first on-demand platform for homeopathy doctor home visits.</div>
								<div class="input">
									<div id="imaginary_container">
										<div class="form-group">
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $city; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $locality; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-3 col-sm-3 col-xs-12 icon-addon addon-md">
												<div class="row">
													<?php echo $speciality; ?>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
											<div class=" col-md-2 col-sm-2 col-xs-12 icon-addon addon-md">
												<div class="row">
													<button type="button" id="searchHomevisitDoctors" class="submit button">SEARCH</button>
													<!--<label for="email" class="glyphicon glyphicon-search" rel="tooltip" title="email"></label>-->
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="step">
									<div class="row">

										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no1.png" alt="1."/>
											<img src="images/home.png" alt="doctor" class="icons"/>
											<p class="">AT HOME SERVICE</p>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no1.png" alt="1."/>
											<img src="images/doctor.png" alt="doctor" class="icons"/>
											<p>CHOOSE A DOCTOR</p>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-4">
											<img src="images/s.no2.png" alt="1."/>
											<img src="images/medical-result.png" alt="doctor" class="icons"/>
											<p class="">100% VERIFIED RESULT</p>
										</div>
									</div>
								</div>
						</div>
						</div>
                    <div class="clearfix"></div>
					</div>

				</div>
                </div>
                </div>
			</div>
		</div>
	</div>
