 <?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Output as HTML5
$doc->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

$doc->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/js/template.js');
//$doc->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/js/jquery.min.js');
//$doc->addScriptVersion($this->baseurl . '/templates/' . $this->template . '/js/bootstrap.min.js');

// Add Stylesheets
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/template.css');

$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css');
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/style.css');
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/responsive.css');
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/header.css');
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/slider.css');
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/font-awesome/css/font-awesome.min.css');
$doc->addStyleSheet('//db.onlinewebfonts.com/c/07689d4eaaa3d530d58826b5d7f84735?family=Montserrat');

// Use of Google Font
/*if ($this->params->get('googleFont'))
{
	$doc->addStyleSheet('//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$doc->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}*/

// Template color
if ($this->params->get('templateColor'))
{
	$doc->addStyleDeclaration("
	body.site {
		border-top: 3px solid " . $this->params->get('templateColor') . ";
		background-color: " . $this->params->get('templateBackgroundColor') . ";
	}
	a {
		color: " . $this->params->get('templateColor') . ";
	}
	.nav-list > .active > a,
	.nav-list > .active > a:hover,
	.dropdown-menu li > a:hover,
	.dropdown-menu .active > a,
	.dropdown-menu .active > a:hover,
	.nav-pills > .active > a,
	.nav-pills > .active > a:hover,
	.btn-primary {
		background: " . $this->params->get('templateColor') . ";
	}");
}

// Check for a custom CSS file
$userCss = JPATH_SITE . '/templates/' . $this->template . '/css/user.css';

if (file_exists($userCss) && filesize($userCss) > 0)
{
	$this->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/user.css');
}

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span6";
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "span9";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "span9";
}
else
{
	$span = "span12";
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
$bottomScript = '
var $ =jQuery.noConflict();
$(window).ready(function() {
		//Set the carousel options
		$("#quote-carousel").carousel({
		pause: true,
		interval: 4000,
		});

		 $("ul#banner_li li").on("click",function(){
											$("div#main_bg_banner").removeClass();
											$("div#main_bg_banner").addClass($(this).attr("data-banner"));
									});
	});';
$doc->addScriptDeclaration($bottomScript);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->
</head>
<body class="<?php if (!$this->countModules('position-1')) : ?> site <?php endif; echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
	echo ($this->direction == 'rtl' ? ' rtl' : '');
?>">
    <div class="<?php if (!$this->countModules('position-1')) : ?> body <?php endif; ?>">
<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : '-fluid'); ?>">
    <div class="common">

		<?php if ($this->countModules('position-0')) : ?>
	<div class="header">
			<div class="row">
				<?php if (!$this->countModules('position-1')) : ?>
					<div class="col-lg-4 col-md-6 col-xs-4 pull-left logo-top">
						<div id='tp-logo'><a class="navbar-brand" href="<?php echo JUri::root(); ?>">
							<?php echo $logo; ?>
						</a></div>
					</div>
				<?php endif; ?>

				<div class="col-lg-4 col-md-6 col-xs-12 pull-right">
					<jdoc:include type="modules" name="position-0" style="none" />

					<?php if (!$this->countModules('position-1') && 1!=1) : ?>
						<li><button type="button" class="hamburger is-closed" data-toggle="offcanvas">
						<span class="hamb-top"></span>
						<span class="hamb-middle"></span>
						<span class="hamb-bottom"></span>
						</button>
					</li>
					<?php endif; ?>						
				</div>
				<div class="cleafix"></div>
			</div>
  	</div>
	  <?php endif; ?>

		<?php if ($this->countModules('position-1')) : ?>
        <!--Navbar start-->
		<div class="navbar_wrapper">
			<div class="col-md-12">
				<nav class="navbar" role="navigation">
					<div class="">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse"
									data-target="#menu" style="z-index:9999;">

								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>

							</button>
							<div class="col-xs-5 col-md-12 col-lg-12 col-sm-9">
							<a class="navbar-brand col-md-12" href="<?php echo JUri::root(); ?>">
								<?php echo $logo; ?>
							</a>
							</div>
						</div>

						<div class="collapse navbar-collapse" id="menu">
							<jdoc:include type="modules" name="position-1" style="none" />							
						</div>
					</div>
				</nav>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php endif; ?>

	</div>

 <!--Navbar End-->
 <?php if ($this->countModules('position-2')) : ?>
		<div>
			<jdoc:include type="modules" name="position-2" style="none" />
		</div>
	<?php endif; ?>


<div class="row-fluid">
	<?php if ($this->countModules('position-8')) : ?>
		<!-- Begin Sidebar -->
		<div id="sidebar" class="span3">
			<div class="sidebar-nav">
				<jdoc:include type="modules" name="position-8" style="xhtml" />
			</div>
		</div>
		<!-- End Sidebar -->
	<?php endif; ?>
    <main id="content" role="main" class="main <?php if($itemid!='435'){ echo 'maintop';  } ?> <?php echo $span; ?>">
		<div <?php if (!$this->countModules('position-1')) : echo "class='container comp_div'";  endif;?> >
			<!-- Begin Content -->
			<jdoc:include type="modules" name="position-3" style="xhtml" />
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<jdoc:include type="modules" name="position-4" style="none" />
			<!-- End Content -->
		</div>
	</main>
	<?php if ($this->countModules('position-7')) : ?>
		<div id="aside" class="span3">
			<!-- Begin Right Sidebar -->
			<jdoc:include type="modules" name="position-7" style="well" />
			<!-- End Right Sidebar -->
		</div>
	<?php endif; ?>
</div>


  <!-- Footer Section -->
	<?php if ($this->countModules('footer')) : ?>
	<footer id="footer-data">
		<jdoc:include type="modules" name="footer" style="xhtml" />
	</footer>
	<?php endif; ?>
	<jdoc:include type="modules" name="debug" style="none" />
	<!-- Footer Section End -->

	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	 <?php if ($this->countModules('position-2')) : ?>
	<?php endif; ?>
	</div> <!--container-fluid end-->
  </body>
</html>
