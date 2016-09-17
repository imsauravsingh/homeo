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
	<h3 class="list-title"> 
		<i class="ico ico-user"></i> <span class="main"><span class="second"><?php echo sprintf(JText::_('COM_EASYAPPOINTMENT_USERS'), $this->category->name);?></span></span>
	</h3>

	<?php foreach ($this->items as $item) { $user_services = $item->getServices(); ?>
	<div class="row listing">
		<div class="col-md-2 left">
			<a class="profilepic" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id . '&service=' . $this->category->id);?>">
				<img src="<?php echo JUri::root();?><?php echo $item->picture ? $this->escape($item->picture) : '/components/com_easyappointment/assets/img/default.png';?>" height="96" width="96" />
			</a>
		</div>
		<div class="col-md-10">
			<h4>
				<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id . '&service=' . $this->category->id);?>">
					<?php echo $this->escape(ucfirst($item->name));?>
				</a>
			</h4>
			
			<?php if ($user_services) {?>
			<p class="serviceslist"><?php foreach ($user_services as $service) {?><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse&category=' . $service->id);?>"><?php echo $this->escape($service->name);?>, </a><?php } ?></p>
			<?php } ?>

			<div class="description">
				<?php echo $item->description;?>
			</div>
				
			<p>
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id . '&service=' . $this->category->id);?>"><i class="ico ico-calendar"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_BOOK_THIS_USER');?></a>
			</p>
			
		</div>
	</div>
	<?php } ?>

</div>
