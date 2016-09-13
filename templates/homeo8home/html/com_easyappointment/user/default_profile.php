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

	<!-- details -->
	<div class="well well-sm header">
		<div class="row">
			<div class="col-md-2 left">
				<a class="profilepic" href="#">
					<img src="<?php echo JUri::root();?><?php echo $this->user->picture ? $this->escape($this->user->picture) : '/components/com_easyappointment/assets/img/default.png';?>" height="96" width="96" />
				</a>
			</div>
			<div class="col-md-10">
				<div class="col-md-6">
					<h2><?php echo $this->escape(ucfirst($this->user->name));?></h2>
				</div>
				<div class="col-md-6">
					<?php if ($this->user->getParams()->get('show_form_prices') == 1) {?>
					<h4><i class="ico ico-info"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_PRICES');?></h4>
					<ul class="prices">
						<?php if ($this->user->getServices()) { ?>
							<?php foreach ($this->user->getServices() as $service) {?>
							<li class="serviceslist">
								<span class="col-md-6"><?php echo $this->escape($service->name);?></span>
								<?php if ($this->user->getParams()->get('show_form_prices') == 1) {?>
								<span class="col-md-6"><?php echo $service->price;?> <?php echo $this->user->getParams()->get('currency');?></span>
								<?php } ?>
							</li>
							<?php } ?>
						<?php } ?>
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

	<?php if ($this->user->getParams()->get('show_specializations') == 1) {?>
	<!-- services -->
	<div class="well well-sm header">
		<h2 class="section-title"><i class="ico ico-suitcase"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SPECIALIZATIONS');?></h2>
		<div class="row">
			<?php if ($this->user->getServices()) { ?>
			<?php foreach ($this->user->getServices() as $service) {?>
			<p class="text-center">
				<a class="btn btn-primary btn-lg" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id='.$this->user->id.'&service=' . $service->id);?>">
					<i class="ico ico-flag"></i> <?php echo sprintf(JText::_('COM_EASYAPPOINTMENT_BOOK_THIS_USER_FOR_SERVICE'),$this->escape($service->name));?>
				</a>
			</p>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
	<!-- /service -->
	<?php } ?>
</div>
