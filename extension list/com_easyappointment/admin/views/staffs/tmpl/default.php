<?php
/*
 * @component EasyAppointment
 * @website : ionutlupu.me
 * @copyright Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');

?>


	<form action="<?php echo JRoute::_('index.php?option=com_easyappointment&view=staffs'); ?>" method="post" name="adminForm" id="adminForm">
		
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>

		<div id="easyapp">
			<div id="j-main-container" class="span10">

				<div id="filter-bar" class="btn-toolbar">
					<div class="btn-group pull-left">
						<input type="text" class="input-sm pull-left" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" />
						<button class="btn btn-default pull-left" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="ico ico-eye"></i></button>
						<button class="btn btn-default pull-left" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="ico ico-close"></i></button>
					</div>				
				</div>

				<div class="clearfix"></div>
			
				<table class="table table-striped">
					<thead>
						<tr>
							<th>
								<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
							</th>

							<th>
								<?php echo JText::_('COM_EASYAPPOINTMENT_STAFFS_NAME'); ?>
							</th>

							<th>
								<?php echo JText::_('COM_EASYAPPOINTMENT_USERNAME'); ?>
							</th>
							
							<th> 
								<?php echo JText::_('COM_EASYAPPOINTMENT_STAFFS_STATUS'); ?>
							</th>

							<th>
								<?php echo JHtml::_('grid.sort', 'COM_EASYAPPOINTMENT_ID', 'a.id', $listDirn, $listOrder); ?>
							</th>
						</tr>
					</thead>

					<tbody>
					<?php foreach ($this->items as $i => $item) {
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<td>
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						
						<td>
							<a href="index.php?option=com_easyappointment&task=staff.edit&id=<?php echo $item->id;?>"><?php echo $this->escape($item->name);?></a>
						</td>

						<td>
							<?php echo JFactory::getUser($item->id)->username;?>
						</td>

						<td>
							<?php echo JHtml::_('jgrid.published', $item->published, $i, 'staffs.', true, 'cb'); ?>
						</td>
						
						<td>
							<?php echo $item->id; ?>
						</td>
						
					</tr>

					<?php } ?>
					</tbody>
							
					<tfoot>
						<tr>
							<td colspan="5">
								<?php echo $this->pagination->getListFooter(); ?>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>

