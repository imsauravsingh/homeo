<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=about'); ?>" method="post" name="adminForm" id="adminForm">
	
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>


	<div id="j-main-container" class="span10">
		<div class="span6 offset3">
				<dl class="dl-horizontal pull-left">
					<dt>Author:</dt>
					<dd>Ionut Lupu (<a href="mailto:contact@ionutlupu.me">contact@ionutlupu.me</a>)</dd>

					<dt>Copyright:</dt> 
					<dd>Ionut Lupu</dd>

					<dt>Official website:</dt> 
					<dd><a target="_blank" href="https://ionutlupu.me">www.ionutlupu.me</a></dd>

					<dt>Contact:</dt> 
					<dd><a href="mailto:contact@ionutlupu.me">contact@ionutlupu.me</a></dd>

					<dt>Version:</dt> 
					<dd><?php echo $this->info->version ;?></dd>
				</dl>

				<div class="clearfix"></div>
				
				<p class="alert alert-success"><i class="icon icon-thumbs-up"></i> If you like EasyAppointment, please give me a vote or write a review on JED: <a target="_blank" href="http://extensions.joomla.org/extensions/extension/vertical-markets/booking-a-reservations/easyappointment">http://extensions.joomla.org/extensions/extension/vertical-markets/booking-a-reservations/easyappointment</a></p> 
			
				<div class="clearfix"></div>

				<div class="well well-small"> <i class="icon icon-info"></i> EasyAppointment distributed "as is". no warranty of any kind is expressed or implied. you use it at your own the author will not be liable for any damages, including but not limited to data loss, loss of profits or any other kind of loss while using or misusing this script.</div>				
		</div>
	</div>

	
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
</form>

