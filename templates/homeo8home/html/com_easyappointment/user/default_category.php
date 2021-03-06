<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
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

$K2User = K2HelperPermissions::getK2User($this->user->id);

?>

<div id="easyapp">
<?php include "consultonline_userheader.php"; ?>

	<!-- calendar -->
	<div class="well well-sm calendar" id="goto">
		<h2 class="section-title"><i class="ico ico-flag"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_BOOK_THIS_USER');?></h2>
		<div id="calendar">
			<span id="calendar-close"><i class="ico ico-close"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLOSE');?> </span>
			<div id="calendar-controls" class="row">
				<?php if ($this->user->getParams()->get('calendar_weeks') >= 2) {?>
				<div class="col-md-6 pull-left"><a href="javascript:void(0);" id="go-back"><i class="ico ico-go-left pull-left"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_NEXT_WEEK');?></a></div>
				<div class="col-md-6"><a href="javascript:void(0);" id="go-next"><i class="ico ico-go-right pull-right"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_LAST_WEEK');?></a></div>
				<?php } ?>
			</div>
			<div class="row">
					<div id="mobile-calendar-navigation">
						<span class="calendar-prev"><a href="javascript:void(0);" id="go-back-cal"><i class="ico ico-go-left"></i></a></span>
						<span class="calendar-next"><a href="javascript:void(0);" id="go-next-cal"><i class="ico ico-go-right"></i></a></span>
					</div>

				<div class="col-md-12" id="calendar-table">
					<?php echo $this->calendar;?>
				</div>
			</div>
		</div>
	</div>
	<!-- /calendar -->

	<?php if ($this->user->getParams()->get('show_specializations') == 1) {?>
	<!-- services -->
	<div class="well well-sm header">
		<h2 class="section-title"><i class="ico ico-suitcase"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SPECIALIZATIONS');?></h2>
		<div class="row">
			<?php if ($this->user->getServices()) { ?>
			<?php foreach ($this->user->getServices() as $service) {?>
			<p class="serviceslist text-center">
				<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id='.$this->user->id.'&service=' . $service->id);?>">
					<i class="ico ico-flag"></i> <?php echo $this->escape($service->name);?>
				</a>
			</p>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
	<!-- /service -->
	<?php } ?>
</div>

<script type="text/javascript">
var eatoken = '<?php echo JFactory::getSession()->getFormToken();?>=1';
var eauser = <?php echo $this->user->id ;?>;
var easervice = <?php echo $this->service->id;?>;
var eamax = <?php echo $this->user->getParams()->get('calendar_weeks') - 1 ;?>;
var earoot = '<?php echo JUri::root();?>';
</script>
