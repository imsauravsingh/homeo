<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<div id="easyapp">

	<ol class="breadcrumb">
		<li><?php echo JText::_('COM_EASYAPPOINTMENT_YOU_ARE_HERE');?>:</li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse');?>"><?php echo JText::_('COM_EASYAPPOINTMENT_SETTINGS_SERVICES');?></a></li>
		<li><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse&category=' . $this->service->id);?>"><?php echo $this->service->name;?></a></li>
		<li class="active"><?php echo $this->user->name;?></li>
	</ol>

	<!-- details -->
	<div class="well well-sm header">
		<div class="row">
			<div class="col-md-2 left">
				<a class="profilepic" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $this->user->id);?>">
					<img src="<?php echo JUri::root();?><?php echo $this->user->picture ? $this->escape($this->user->picture) : '/components/com_easyappointment/assets/img/default.png';?>" height="96" width="96" />
				</a>
			</div>
			<div class="col-md-10">
				<div class="col-md-6">
					<h2><?php echo $this->escape(ucfirst($this->user->name));?></h2>
					<p>
						<a class="btn btn-primary btn-lg" href="#goto" id="appointment">
							<i class="ico ico-calendar"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_BOOK_THIS_USER');?>
						</a>
					</p>
				</div>

				<div class="col-md-6">
					<?php if ($this->user->getParams()->get('show_form_prices') == 1) {?>
					<h4><i class="ico ico-info"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_PRICES');?></h4>
					<ul class="prices">
						<li class="serviceslist">
							<span class="col-md-6"><?php echo $this->escape($this->service->name);?></span>
							<span class="col-md-6"><?php echo $this->service->price;?> <?php echo $this->user->getParams()->get('currency');?></span>
						</li>
					</ul>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-10 col-md-offset-2 description">
				<?php echo $this->user->description;?>
			</div>			
		</div>
	</div>
	<!-- /details -->

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
