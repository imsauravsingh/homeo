<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$parts = array( 1=>'MONDAY', 2=>'TUESDAY', 3=>'WEDNESDAY', 4=>'THURSDAY', 5=>'FRIDAY', 6=>'SATURDAY', 7=>'SUNDAY', 8=>'COM_EASYAPPOINTMENT_SPECIAL_DAYS');

?>

<div id="easyapp">

	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=schedules', false);?>" method="post" name="adminForm" id="adminForm" class="form-horizontal">
		
		<?php echo MedialDisplay::loadMenu() ;?>

		<div id="tb-controls">
		    <div class="col-md-4 pull-left">
			<h3><i class="ico ico-clock"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SCHEDULES');?></h3>
		    </div>
		</div>

		<div class="row tbb-action">
			<div class="col-md-9 pull-left">
				<button class="btn" onclick="tbb.save();"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
			</div>
		</div>


		<!-- add new interval form -->
		<div id="addSchedule">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_WORKING_INTERVALS');?></h3>
				</div>

				 <div class="panel-body">
					
					<div class="form-group">
						<select class="input-lg col-md-offset-1 col-md-3" id="addStart">
							<option value="0"> - <?php echo JText::_('COM_EASYAPPOINTMENT_SELECT_START_HOUR') ;?> - </option>
							<?php echo JHtml::_('select.options', $this->user->getSchedule()->getDefaultHours()) ;?>
						</select>
					</div>

					<div class="form-group">
						<select class="input-lg col-md-offset-1 col-md-3" id="addEnd">
							<option value="0"> - <?php echo JText::_('COM_EASYAPPOINTMENT_SELECT_END_HOUR') ;?> - </option>
							<?php echo JHtml::_('select.options', $this->user->getSchedule()->getDefaultHours()) ;?>
						</select>
					</div>

					<div class="form-group">
						<div class="col-md-offset-1">
							<button class="input-lg btn btn-default" id="btn-save"><i class="ico ico-accept"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_SAVE');?></button>
							<button class="input-lg btn btn-default" id="btn-cancel"><i class="ico ico-close"></i> <?php echo JText::_('COM_EASYAPPOINTMENT_CLOSE');?></button>
						</div>
					</div>
			
				</div>
			</div>
		</div>
		<!-- /add new interval form -->


		<?php for ($i=1; $i<=7; $i++) { ?>
		<!-- day -->
		<div class="day" data-id="<?php echo $i;?>" id="part-<?php echo $i;?>">

			<!-- schedules -->
			<div class="well well-lg">

				<p class="clearfix">
				<?php for ($j=1; $j<=7; $j++) {?>
				<a class="btn-sm pull-left" href="#part-<?php echo $j;?>"><?php echo JText::_($parts[$j]);?></a>	
				<?php } ?>	
				<a class="btn-sm pull-left" href="#special"><?php echo JText::_($parts[8]);?></a>	
				<a class="pull-right" href="#tbb-nav"><?php echo JText::_('COM_EASYAPPOINTMENT_TOP');?></a>
				</p>

				<?php $schedule = $this->user->getSchedule($i); ?>

				<h2><?php echo JText::_($parts[$i]);?></h2>
				<p class="status-info" id="status-for-<?php echo $i;?>">	
					<span class="label label-info active">
						<?php echo $schedule->working ? JText::_('COM_EASYAPPOINTMENT_WORKING_DAY') : JText::_('COM_EASYAPPOINTMENT_FREE_DAY') ;?>
					</span>
				</p>

				<div class="schedules">
					<table class="table" id="table-<?php echo $i;?>">
						<thead>
							<tr>
								<th><?php echo JText::_('COM_EASYAPPOINTMENT_START');?></th>
								<th><?php echo JText::_('COM_EASYAPPOINTMENT_END');?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php  $intervals = $schedule->getIntervals(); if (empty($intervals)) { ?>
							<tr class="standard" id="intervals_for_<?php echo $i;?>">
								<td colspan="3">
									<?php echo JText::sprintf(JText::_('COM_EASYAPPOINTMENT_NO_DEFINED_SCHEDULE_USE_DEFAULT_HOURS'), $schedule->getMin(true),$schedule->getMax(true));?>
								</td>
							</tr>
							<?php } else { foreach ($intervals as $interval) { ?>
							<tr class="intervals">
								<td data-value="<?php echo $interval['start'];?>"><?php echo MedialDisplay::showTime($interval['start'], $this->user->getParams()->get('hour_format')); ?></td>
								<td data-value="<?php echo $interval['end'];?>"><?php echo MedialDisplay::showTime($interval['end'], $this->user->getParams()->get('hour_format')); ?></td>
								<td><i data-id="<?php echo $i;?>" class="btn-del ico ico-close"></i></td>
							</tr>
							<?php } } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">
									<button class="btn btn-primary btn-add" data-id="<?php echo $i;?>"><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_WORKING_INTERVALS');?></button>
									<button class="btn btn-toogle-work" data-id="<?php echo $i;?>" data-status="<?php echo $schedule->working;?>"><?php echo $schedule->working ? JText::_('COM_EASYAPPOINTMENT_TOOGLE_DAY_STATE_0') : JText::_('COM_EASYAPPOINTMENT_TOOGLE_DAY_STATE_1');?></button>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<!-- schedules -->
		</div>
		<!-- /day -->
		<?php } ?>
		

		<!-- special days -->
		<div class="well well-lg" id="special">
			<table class="table">
				<thead>
					<tr><th colspan="3"><h2><?php echo JText::_('COM_EASYAPPOINTMENT_SPECIAL_DAYS');?></h2></th></tr>
					<tr><th colspan="3"><button class="btn btn-primary" onclick="tbb.newSpecialDay();return false;"><?php echo JText::_('COM_EASYAPPOINTMENT_ADD_SPECIAL_DAY');?></button></th></tr>
				</thead>
				<tbody>
					<?php foreach ($this->specials as $special) {?>
					<tr class="specials">
						<td colspan="2">
							<a href="<?php echo JRoute::_('index.php?option=com_easyappointment&view=special&date=' . $special);?>"><?php echo MedialDisplay::showDate($special,$this->user->getParams()->get('date_format'));?></a>
						</td>
						<td>
							<i class="btn-del-special ico ico-close" data-date="<?php echo $special;?>"></i>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<!-- special days -->

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>

<script type="text/javascript">
tbb.token = '<?php echo JFactory::getSession()->getFormToken();?>=1';
tbb.user = <?php echo $this->user->id;?>;
tbb.root = '<?php echo JUri::root();?>';
</script>
