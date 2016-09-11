<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$i = 0;
?>

<div id="easyapp">
	<h3 class="list-title">
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse', false);?>"><i class="ico ico-home"></i></a>
			<span class="main"><span class="second"><?php echo JText::_('COM_EASYAPPOINTMENT_CATEGORIES');?></span></span>
	</h3>
	<?php foreach ($this->items as $item) { ?>
	<div class="row">
		<div class="col-md-6 service">
			<h4><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=browse&category=' . $item->id, false);?>"><?php echo $item->name;?></a></h4>
		</div>
		<div class="col-md-6">
			<?php if ($item->description) {?>
				<div class="well well-sm sdescription"><?php echo $item->description;?></div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>
