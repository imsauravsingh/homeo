<?php

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

$item = $this->user;
$book_appointment = $item->getParams()->get('book_appointment');
$book_appointment_fee = $item->getParams()->get('book_appointment_fee');
$consult_online = $item->getParams()->get('consult_online');

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
    <p class="serviceslist"><i class="fa fa-stethoscope fa-fw"></i>&nbsp;<?php foreach ($user_services as $service) {?><?php echo $this->escape($service->name);?>, <?php } ?></p>
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
                  <img style="width:50px" title="<?php echo $value->attachment_name; ?>" src="<?php echo JURI::root().DS.'images'.DS.'clinic_images'.DS.$item->id.DS.$value->clinic_image; ?>">
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
    <?php if($consult_online->enable && $consult_online->chat_enable){ ?>
      <p><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i>
      <i class="fa fa-inr" aria-hidden="true"></i> <?php echo (!empty($consult_online->chat_fee)?$consult_online->chat_fee:JText::_('NOT_AVAILABLE_ONLINE_CLINIC')); ?><?php echo JText::_('ONLINE_CHAT'); ?></p>
    <?php } ?>
    <?php if($consult_online->enable && $consult_online->video_enable){ ?>
      <p><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i>
      <i class="fa fa-inr" aria-hidden="true"></i> <?php echo (!empty($consult_online->video_fee)?$consult_online->video_fee:JText::_('NOT_AVAILABLE_ONLINE_CLINIC')); ?><?php echo JText::_('ONLINE_VIDEO'); ?></p>
    <?php } ?>

    </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
