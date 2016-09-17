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
	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=stafflist');?>" method="post" id="adminForm" name="adminForm">
	
	<h3 class="list-title">
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=stafflist', false);?>"><i class="ico ico-user"></i></a> 
			<span class="main"><span class="second"><?php echo JText::_('COM_EASYAPPOINTMENT_STAFF');?></span></span>
	</h3>

	<?php foreach ($this->items as $item) { ?>
	<div class="row">
		<div class="col-md-3 pull-left">
			<a class="profilepic" href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id, false);?>">
				<img src="<?php echo $item->picture ? $item->picture : 'components/com_easyappointment/assets/img/default.png';?>" height="96" width="96">
			</a>
		</div>
		<div class="col-md-9 pull-left">
			<h4><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=user&id=' . $item->id, false);?>"><?php echo $item->name;?></a></h4>
			<?php if ($item->description) {?>
				<div class="well well-sm sdescription"><?php echo $item->description;?></div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

	<div class="row">
		<?php echo $this->pagination->getListFooter() ;?>
	</div>
	
	</form>
</div>
