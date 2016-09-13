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

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=management', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">

		<?php //echo MedialDisplay::loadMenu() ;?>

		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><i class="ico ico-home"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_DASHBOARD');?></h3>
		    </div>
		</div>

		<div class="text-center">
			<button class="btn btn-lg" onclick="bnew();return false;"><i class="ico ico-add"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_NEW_BOOKING');?></button>
		</div>

		<div class="spacer"></div>

		<?php if ($this->bookings) { ?>
		<h4 class="text-center"><?php echo JText::_('COM_EASYAPPOINTMENT_YOUR_TODAY_BOOKINGS');?></h4>
		<table class="table table-hover">
			<thead>
				<tr>
					<th><i class="ico ico-clock"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_FROM_HOUR');?> <i class="ico ico-go-right"></i></th>
					<th><i class="ico ico-go-left"></i> <i class="ico ico-clock"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_TO_HOUR');?></th>
					<th><i class="ico ico-flag"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SERVICE');?></th>
					<th><i class="ico ico-user"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLIENT');?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($this->bookings as $booking) {?>
					<tr>
						<td><?php echo MedialDisplay::showTime($booking->startingTime, $this->staff->getParams()->get('hour_format')); ?></td>
						<td><?php echo MedialDisplay::showTime($booking->endingTime, $this->staff->getParams()->get('hour_format')); ?></td>
						<td><?php echo MedialService::getInstance($booking->service)->get('name'); ?></td>
						<td><a href="<?php echo JRoute::_('index.php?option=com_easyappointment&task=booking.edit&id=' . $booking->id);?>"><?php echo $this->escape($booking->name);?></a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>

		<div class="row spacer"></div>

		<div class="row">
			<h4 class="text-center"><?php echo JText::_('COM_EASYAPPOINTMENT_YOUR_SERVICES');?></h4>
			<?php if ($this->staff->getServices()) { foreach ($this->staff->getServices() as $service) { { ?>
				<p class="text-center"><?php echo $service->name;?></p>
			<?php } } }  ?>
		</div>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
				
	</form>
	<div class="Quick_icons">
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-file-o" aria-hidden="true"></i>
			  <p>Add new item</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-files-o fa-fw" aria-hidden="true"></i>
			  <p>item</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-star-o" aria-hidden="true"></i>
			  <p>Featured items</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-trash-o" aria-hidden="true"></i>
			  <p> Trashed items</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-folder-open-o" aria-hidden="true"></i>
			  <p>Categories</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-tags" aria-hidden="true"></i>
			  <p>Tags</p>	
			 </a>
			</div>
		</div>
		<div class="clr"></div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-comments-o" aria-hidden="true"></i>
			  <p>Comments</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-object-ungroup" aria-hidden="true"></i>
			  <p>Extra fields</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-object-group" aria-hidden="true"></i>
			  <p>Extra fields group</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-film" aria-hidden="true"></i>
			  <p>Media manager</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-picture-o" aria-hidden="true"></i>
			  <p>Online image editor</p>	
			 </a>
			</div>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<div class="add_icons text-center">
			 <a href="#">
			  <i class="fa fa-file-text" aria-hidden="true"></i>
			  <p>Document</p>	
			 </a>
			</div>
		</div>
		<div class="clr"></div>
	</div>
</div>


<script type="text/javascript">
	function bnew() {
		document.adminForm.task.value = 'booking.add';
		document.adminForm.submit();
	}
</script>
