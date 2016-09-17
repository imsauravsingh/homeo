<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Homeo
 * @author     saurav <imsauravsingh@gmail.com>
 * @copyright  2016 saurav
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_homeo', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_homeo/js/form.js');


?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-homeo').submit(function (event) {
				
			});

			
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-homeo').submit(function (event) {
				
			});

			
		});
	}
</script>

<div class="homeo-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-homeo"
		  action="<?php echo JRoute::_('index.php?option=com_homeo&task=homeo.save'); ?>"
		  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary">
						<?php echo JText::_('JSUBMIT'); ?>
					</button>
				<?php endif; ?>
				<a class="btn"
				   href="<?php echo JRoute::_('index.php?option=com_homeo&task=homeoform.cancel'); ?>"
				   title="<?php echo JText::_('JCANCEL'); ?>">
					<?php echo JText::_('JCANCEL'); ?>
				</a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_homeo"/>
		<input type="hidden" name="task"
			   value="homeoform.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
