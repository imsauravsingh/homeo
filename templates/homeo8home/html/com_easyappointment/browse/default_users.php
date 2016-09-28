<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.modal','a.modal-thumbnail');


$permission_file = JPATH_BASE."/components/com_k2/helpers/permissions.php";
require_once($permission_file);

$name_prefix = "Mr. ";
if(in_array(14, $user->groups)){
    $name_prefix = "Dr. ";
}elseif($K2User->gender=='m'){
    $name_prefix = "Mr. ";
}else{
    $name_prefix = "Mrs. ";
}
$itemid = JRequest::getVar( 'Itemid' );
$search_data_bytab = JRequest::getVar( 'search_data_bytab' );



?>
<div id="easyapp">
	<!--<h3 class="list-title">
		<i class="fa fa-user-md fa-fw"></i><span class="main"><span class="second"><?php echo sprintf(JText::_('COM_EASYAPPOINTMENT_USERS'), $this->category->name);?></span></span>
	</h3>-->

	<?php
  foreach ($this->items as $item) {
    $book_appointment = $item->getParams()->get('book_appointment');
    $book_appointment_fee = $item->getParams()->get('book_appointment_fee');
    $consult_online = $item->getParams()->get('consult_online');
    $home_visit = $item->getParams()->get('home_visit');

    if($search_data_bytab=="consult_online" && $consult_online->enable!=1) continue;
    else if($search_data_bytab=="book_appointment" && $book_appointment->enable!=1) continue;
    else if($search_data_bytab=="home_visit" && $home_visit->homevisit_enable!=1) continue;


    $clinic_images = MedialStaff::getClinicImages($item->id);
    $profile_display = $item->getParams()->get('profile_display');
    $edu= MedialStaff::getProfilData($profile_display, 'edu');
    $exp= MedialStaff::getProfilData($profile_display, 'exp');
    $K2User = K2HelperPermissions::getK2User($item->id);
    $user_services = $item->getServices();
    $general = $item->getParams()->get('general');
    ?>

	<div class="listing staff">
		<div class="col-md-2 left">
			<div class="staff_image">
				<a class="profilepic" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id . '&service=' . $this->category->id);?>">
                                    <?php if ($K2User->image): ?>
                                        <img class="k2AccountPageImage img-circle" src="<?php echo JURI::root(true).'/media/k2/users/'.$K2User->image; ?>" alt="<?php echo $user->name; ?>" />
                                    <?php elseif($K2User->gender=='m'): ?>
                                        <img src="<?php echo JURI::root(true).'/images/User2.jpg'; ?>" alt="img" class="img-circle"/>
                                    <?php elseif($K2User->gender!='m'): ?>
                                        <img src="<?php echo JURI::root(true).'/images/User.jpg'; ?>" alt="img" class="img-circle"/>
                                    <?php endif; ?>
				</a>
			</div>
		</div>
		<div class="col-md-10">
			<div class="row">
			<div class="col-md-8 col-sm-9 col-xs-12">
			<h4>
				<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id . '&service=' . $this->category->id);?>">
					<?php echo $this->escape(ucfirst($item->name));?>
				</a>
			</h4>

			<?php if ($user_services) {?>
			<p class="serviceslist"><i class="fa fa-stethoscope fa-fw"></i>&nbsp;<?php foreach ($user_services as $service) {?><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse&category=' . $service->id);?>"><?php echo $this->escape($service->name);?>, </a><?php } ?></p>
			<?php } ?>
      <p><i class="fa fa-graduation-cap fa-fw"></i><?php if(count($edu)){ echo " ".strtoupper(implode(", ",$exp)); }else{ echo " ".JText::_("NOT_AVAILABLE_EDUCATION"); } ?></p>
			<p><i class="fa fa-map-marker fa-fw"></i><?php echo (($book_appointment->clinic_address!="")?" ".ucfirst($book_appointment->clinic_address):" ".JText::_('NOT_AVAILABLE_CLINIC_ADDRESS')); ?></p>
			<div class="row">
        <?php

        if(count($clinic_images)){
          $i=0;
          foreach ($clinic_images as $key => $value) { $i++;
            if(file_exists(JPATH_SITE.DS.'images'.DS.'clinic_images'.DS.$item->id.DS.$value->clinic_image)){ ?>
              <div class="col-lg-2 col-xs-3">
                  <a class="modal-thumbnail thumbnail bottom" title="<?php echo $value->attachment_name; ?>" href="<?php echo JURI::root().DS.'images'.DS.'clinic_images'.DS.$item->id.DS.$value->clinic_image; ?>">
                    <img style="width:50px;height:50px" title="<?php echo $value->attachment_name; ?>" src="<?php echo JURI::root().DS.'images'.DS.'clinic_images'.DS.$item->id.DS.$value->clinic_image; ?>">
                  </a>
                  <?php if($i==4 && ((count($clinic_images)-$i)!=0) ){ ?><span class="clinicimg_count"><?php echo count($clinic_images)-$i; ?></span><?php } ?>
              </div>
            <?php
            if($i==4) break;
          }
          }
        }
        ?>
			</div>
			<div class="description">
				<?php echo $item->description;?>
			</div>

			</div>
			<div class="col-md-4 col-sm-3 col-xs-12">
        <?php if(count($exp)){
          foreach($exp as $expvalue){ ?>
            <p><i class="fa fa-suitcase fa-fw" aria-hidden="true"></i> <?php echo ucfirst($expvalue); ?></p>
          <?php }
        } ?>
			<?php if($book_appointment->enable){ ?>
        <p><i class="fa fa-money fa-fw" aria-hidden="true"></i>
			       <i class="fa fa-inr" aria-hidden="true"></i> <?php echo (!empty($book_appointment_fee)?$book_appointment_fee:JText::_('NOT_AVAILABLE_BOOKAPPOINTMENT_AVAILABILITY')); ?> at clinic
           </p>
      <?php } ?>
      <?php $j=0; if($consult_online->enable && $consult_online->chat_enable){ ?>
        <p><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i>
  			<i class="fa fa-inr" aria-hidden="true"></i> <?php echo (!empty($consult_online->chat_fee)?$consult_online->chat_fee:JText::_('NOT_AVAILABLE_ONLINE_CLINIC')); ?><?php echo JText::_('ONLINE_CHAT'); ?></p>
      <?php $j=1; } ?>

      <?php if($consult_online->enable && $consult_online->video_enable && $j==0){ ?>
        <p><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i>
  			<i class="fa fa-inr" aria-hidden="true"></i> <?php echo (!empty($consult_online->video_fee)?$consult_online->video_fee:JText::_('NOT_AVAILABLE_ONLINE_CLINIC')); ?><?php echo JText::_('ONLINE_VIDEO'); ?></p>
      <?php } ?>

      <?php if($home_visit->homevisit_enable){ ?>
        <p><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i>
  			<i class="fa fa-inr" aria-hidden="true"></i> <?php echo (!empty($home_visit->homevisit_fee)?$home_visit->homevisit_fee:JText::_('NOT_AVAILABLE_ONLINE_CLINIC')); ?><?php echo JText::_('HOME_VISIT'); ?></p>
      <?php } ?>

			</div>
			</div>
		</div>
		<div class="clearfix"></div>

			<p>
			<div class="buttons text-center">
        <?php $disable_booking=""; if($book_appointment->enable){ $disable_booking="disable_booking"; }?>
				<div class="col-sm-4 col-xs-12 btn <?php echo $disable_booking; ?>">
          <?php if(empty($disable_booking)){ ?>
              <a class="hide_booking_link" href="#"><?php echo JText::_('COM_EASYAPPOINTMENT_BOOK_THIS_USER');?></a>
          <?php }else{ ?>
				      <a class="" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&Itemid='.$itemid.'&id=' . $item->id . '&service=' . $this->category->id);?>"><?php echo JText::_('COM_EASYAPPOINTMENT_BOOK_THIS_USER');?></a>
        <?php } ?>
				</div>

        <?php $disable_consultonline= ""; if($consult_online->enable && ($consult_online->chat_enable || $consult_online->video_enable)){ $disable_consultonline="disable_consultonline"; }?>
				    <div class="col-sm-4 col-xs-6 btn <?php echo $disable_consultonline; ?>">
              <?php if(empty($disable_booking)){ ?>
                  <a class="hide_booking_link" href="#">Consult Online</a>
              <?php }else{ ?>
                  <a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&user_type=online&Itemid='.$itemid.'&id=' . $item->id . '&service=' . $this->category->id);?>">Consult Online</a>
            <?php } ?>
            </div>

            <?php $disable_homevisit= ""; if($home_visit->homevisit_enable){ $disable_homevisit="disable_homevisit"; }?>
    				    <div class="col-sm-4 col-xs-6 btn <?php echo $disable_homevisit; ?>">
                  <?php if(empty($disable_homevisit)){ ?>
                      <a class="hide_booking_link" href="#">Home Visit</a>
                  <?php }else{ ?>
                      <a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&user_type=homevisit&Itemid='.$itemid.'&id=' . $item->id . '&service=' . $this->category->id);?>">Home Visit</a>
                <?php } ?>
                </div>

			</div>

			</p>
	</div>
	<?php } ?>

</div>
