<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
?>
<div class="h8hregistration">
<div class="registration<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
		</div>
	<?php endif; ?>

	<div class="row registration-image">
		<div class="container">
		<p>Launch your practice online. Effortlessly connect
		<br>with your patients across geographies through
		<br>online video consultation.
		</p>
		</div>
	</div>
	<div class="row bg">
		<div class="container">
		<div class="rg_sections">
		<div class="text-center"><h2>About Homeo8home</h2></div>
		<p>ealthkon is an on-demand healthcare delivery platform that enables patients to schedule appointments and have video consultation with practitioners in the Traditional, Complementary and Alternative Medicine (TCAM) segment.
		<br><br>
		Some of the best TCAM practitioners, spiritual masters and energy healers in India carry out their online practice using the Healthkon platform.</p>
		</div>
		</div>
		<svg class="bot_triangle" xmlns="#" version="1.1" width="100%" height="100" viewBox="0 0 100 102" preserveAspectRatio="none">
			<path class="white" d="M0 0 L50 100 L100 0 Z" />
		</svg>
	</div>
	<div class="row bg_lightpurple">
		<div class="container">
		<div class="rg_sections">
		 <div class="text-center"><h2>Why Should A Practitioner Sign-Up On Homeo8home ?</h2></div>
			<div class="margin_top20">
			<h3>Establish your practice online</h3>
			<div class="">Launch your practice online using the Homeo8home platform. Everything is taken care of, you just need take the first step to sign-up. Our dedicated team will familiarize you with the tool and assist you through the onboarding process.</div>
			</div>
			<div class="margin_top20">
			<h3>Grow your practice</h3>
			<div class="">By overcoming geographical limitations and utilizing Homeo8home’s web based video consulting platform.</div>
			</div>
			<div class="margin_top20">
			<h3>Monetize your time</h3>
			<div class="">Cash in your available hours online with Homeo8home.</div>
			</div>
			<div class="margin_top20">
			<h3>Leverage the platform to suit your convenience</h3>
			<div class="">No more spending hours at your clinic handling patients without appointments and missing out on other important engagements. Choose your own time slots, and only once you approve an appointment is your consultation booked.</div>
			</div>
			<div class="margin_top20">
			<h3>Engage with an elite network of TCAM peers</h3>
			<div class="">The platform is your professional network gateway too! It enables practitioners to connect with each other across therapies to discuss cases for the benefit of the patient, or simply connect and enhance their network through our internal messaging capabilities.</div>
			</div>
			<div class="margin_top20">
			<h3>Publish your own journals, articles & successful cases</h3>
			<div class="">Showcase your work on the Homeo8home blog which has wide online circulation and recognition. You can also get access to various write-ups by our other experts about the latest developments in TCAM.</div>
			</div>
		</div>
		</div>
		<svg class="bot_triangle" xmlns="#" version="1.1" width="100%" height="100" viewBox="0 0 100 102" preserveAspectRatio="none">
			<path class="fade_white" d="M0 0 L50 100 L100 0 Z" />
		</svg>
	</div>
	<div class="row bg">
		<div class="container">
		<div class="rg_sections">
			<div class="text-center"><h2>Manage Your Patients' Expectations By</h2></div>
			<div class="row">
			<div class="col-md-4 text-right">
			<div class="process"><span style="color:#886895;">Answer questions</span> for disease management, wellness and rehabilitation</div>
			<div class="process"><span style="color:#886895;">Diagnose and treat</span> non-communicable diseases</div>
			<div class="process"><span style="color:#886895;">Write advice and treatment</span> and share with patients</div>
			</div>
			<div class="col-md-4 text-center">
			<img src="images/hand.png" alt="img"/>
			</div>
			<div class="col-md-4 text-left">
			<div class="process"><span style="color:#886895;">Be available for a follow-up audio call</span> to check patients progress within 7 days of consultation</div>
			<div class="process"><span style="color:#886895;">Refer patients'</span>to other specialists, if required</div>
			<div class="process"><span style="color:#886895;">Maintain an online record</span>of patient history to be used anytime</div>
			</div>

			</div>
			<svg class="bot_triangle" xmlns="#" version="1.1" width="100%" height="100" viewBox="0 0 100 102" preserveAspectRatio="none">
			<path class="white" d="M0 0 L50 100 L100 0 Z" />
			</svg>
		</div>
		</div>
	</div>
	<div class="row bg_lightpurple">
		<div class="container">
			<div class="rg_sections">
			<div class="text-center"><h2>How To Sign-Up</h2></div>
			<div class="panel panel-default col-xs-12 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-lg-6 col-lg-offset-3">
			  <div class="row panel-heading">Fill out this form</div>
			  <div class="panel-body">
				<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal " enctype="multipart/form-data">
		<?php // Iterate through the form fieldsets and display each one. ?>
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<fieldset>
				<?php // If the fieldset has a label set, display it as the legend. ?>
				<?php if (isset($fieldset->label)): ?>
					<!--<legend><?php echo JText::_($fieldset->label);?></legend>-->
				<?php endif;?>
				<?php // Iterate through the fields in the set and display them. ?>
				<?php foreach ($fields as $field) : ?>
					<?php // If the field is hidden, just display the input. ?>
					<?php if ($field->hidden): ?>
						<?php echo $field->input;?>
					<?php else:?>
						<div class="control-group">
							<?php if($field->id=='jform_profile_tos'){ ?>
								<div class="controls termchkbox">
									<?php echo $field->input;?>
								</div>
								<div class="control-label termtext">
								<?php echo $field->label; ?>
								<?php if (!$field->required && $field->type != 'Spacer') : ?>
									<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
								<?php endif; ?>
								</div>
							<?php }else{ ?>
								<div class="control-label">
								<?php echo $field->label; ?>
								<?php if (!$field->required && $field->type != 'Spacer') : ?>
									<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL');?></span>
								<?php endif; ?>
								</div>
								<div class="controls">
									<?php echo $field->input;?>
								</div>
							<?php } ?>
						</div>
					<?php endif;?>
				<?php endforeach;?>
				</fieldset>
			<?php endif;?>
		<?php endforeach;?>
		<div class="control-group">
			<div class="text-center">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER');?></button>
				<a class="btn" id="close" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
				<input type="hidden" name="type" value="14" />
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="registration.register" />
			</div>
		</div>
		<?php echo JHtml::_('form.token');?>
	</form>
			  </div>
			</div>
			<div class="clearfix"></div>
			</div>
			<span style="color:#886895;font-weight:bold;"> Give us a call on 1-800-833-8108 or drop us an email at homeo8home.com.</span> We will take it from there and ensure that your on boarding is seamless. We will also hand-hold you through your first experience with the tool and assist you with any queries you may have. All this at your own convenience!
		</div>
		<p>&nbsp;</p>
	</div>


</div>
</div>
