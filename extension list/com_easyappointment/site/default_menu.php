<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$current_view = JRequest::getCmd('view');
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" id="tbb-nav">
  <div class="">
	<ul class="nav navbar-nav nav-pills" id="tbb-navigation">

		<li <?php echo $current_view == 'management' ? 'class="active"' : '' ?>>
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=management', true);?>">
				<i class="ico ico-home"></i>
				<?php echo JText::_('COM_EASYAPPOINTMENT_DASHBOARD');?>
			</a>
		</li>

		<li <?php echo preg_match('/booking(s)?/', $current_view) ? 'class="active"' : '' ?>>
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=bookings', true);?>">
				<i class="ico ico-bookings"></i>
				<?php echo JText::_('COM_EASYAPPOINTMENT_BOOKINGS');?>
			</a>
		</li>

		<li <?php echo $current_view == 'settings' ? 'class="active"' : '' ?>>
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=settings', true);?>">
				<i class="ico ico-settings"></i>
				<?php echo JText::_('COM_EASYAPPOINTMENT_SETTINGS');?>
			</a>
		</li>

		<li <?php echo $current_view == 'schedules' ? 'class="active"' : '' ?>>
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=schedules', true);?>">
				<i class="ico ico-clock"></i>
				<?php echo JText::_('COM_EASYAPPOINTMENT_SCHEDULES');?>
			</a>
		</li>

		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&task=logout', true);?>">
				<i class="ico ico-exit"></i>
				<?php echo JText::_('COM_EASYAPPOINTMENT_LOGOUT');?>
			</a>
		</li>
	</ul>
  </div>
</nav>
