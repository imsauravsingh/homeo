<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_accordionmenu
 * @copyright	Copyright (C) 2004 - 2015 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;
$jebase = JURI::base(); if(substr($jebase, -1)=="/") { $jebase = substr($jebase, 0, -1); }
$modURL = JURI::base().'modules/mod_je_accordionmenu';
$menulinkcolor = $params->get('menulinkcolor','#ffffff');
$menulinkcolorsub = $params->get('menulinkcolorsub ','#ffffff');
$menucolor = $params->get('menucolor','#49525e');
$menucolorsub = $params->get('menucolorsub','#49525e');
$accordion = $params->get('accordion','mouseenter');
$speed = $params->get('speed','normal');
$fontStyle = $params->get('fontStyle','Open+Sans');

// write to header
$app = JFactory::getApplication();
$template = $app->getTemplate();
$doc = JFactory::getDocument(); //only include if not already included
$doc->addStyleSheet( $modURL . '/css/style.css');
$doc->addStyleSheet( 'http://fonts.googleapis.com/css?family='.$fontStyle.'');
$fontStyle = str_replace("+"," ",$fontStyle);
$fontStyle = explode(":",$fontStyle);
$je_dark1 = adjustColor($menucolor, "-20");
$je_dark2 = adjustColor($menucolor, "-40") ;
$je_dark3 = adjustColor($menucolorsub, "-20") ;
$je_dark4 = adjustColor($menucolorsub, "-40") ;
$style = "
#je_accord".$module->id.".je_acc {color: ".$menulinkcolor."; font-family: '".$fontStyle[0]."', Arial, sans-serif;}
#je_accord".$module->id.".je_acc > ul > li > a { border-left: 1px solid ".$je_dark2."; border-right: 1px solid ".$je_dark2."; border-top: 1px solid ".$je_dark2."; color: ".$menulinkcolor."; background: ".$menucolor.";}
#je_accord".$module->id.".je_acc > ul > li > a:hover,
#je_accord".$module->id.".je_acc > ul > li.active > a,
#je_accord".$module->id.".je_acc > ul > li.open > a { color: ".$menulinkcolor."; background: ".$je_dark1.";}
#je_accord".$module->id.".je_acc > ul > li.open > a { border-bottom: 1px solid ".$je_dark2.";}
#je_accord".$module->id.".je_acc > ul > li:last-child > a,
#je_accord".$module->id.".je_acc > ul > li.last > a {border-bottom: 1px solid ".$je_dark2.";}
#je_accord".$module->id." .holder::after { border-top: 2px solid ".$menulinkcolor."; border-left: 2px solid ".$menulinkcolor.";}
#je_accord".$module->id.".je_acc > ul > li > a:hover > span::after,
#je_accord".$module->id.".je_acc > ul > li.active > a > span::after,
#je_accord".$module->id.".je_acc > ul > li.open > a > span::after { border-color: ".$menulinkcolor.";}
#je_accord".$module->id.".je_acc ul ul li a { border-bottom: 1px solid ".$je_dark4."; border-left: 1px solid ".$je_dark4."; border-right: 1px solid ".$je_dark4."; color: ".$menulinkcolorsub."; background: ".$menucolorsub.";}
#je_accord".$module->id.".je_acc ul ul li:hover > a,
#je_accord".$module->id.".je_acc ul ul li.open > a,
#je_accord".$module->id.".je_acc ul ul li.active > a { color: ".$menulinkcolorsub."; background: ".$je_dark3.";}
#je_accord".$module->id.".je_acc > ul > li > ul > li.open:last-child > a,
#je_accord".$module->id.".je_acc > ul > li > ul > li.last.open > a { border-bottom: 1px solid ".$je_dark4.";}
#je_accord".$module->id.".je_acc ul ul li.has-sub > a::after { border-top: 2px solid ".$menulinkcolorsub."; border-left: 2px solid ".$menulinkcolorsub.";}
#je_accord".$module->id.".je_acc ul ul li.active > a::after,
#je_accord".$module->id.".je_acc ul ul li.open > a::after,
#je_accord".$module->id.".je_acc ul ul li > a:hover::after { border-color: ".$menulinkcolorsub.";}
";
$doc->addStyleDeclaration( $style );
if ($params->get('jQuery')) {$doc->addScript ('http://code.jquery.com/jquery-latest.pack.js');}
$doc = JFactory::getDocument();

$je_anim = "";
if ($accordion == 'click') { $je_anim = "jQuery(this).removeAttr('href');" ; }
$js = "
jQuery( function( ) {
	jQuery( document ).ready(function() {
	jQuery('.active').addClass('open');
	jQuery('.active').children('ul').slideDown();
	jQuery('#je_accord".$module->id." li.has-sub>a').on('".$accordion."', function(){
			".$je_anim."
			var element = jQuery(this).parent('li');

			if (element.hasClass('open')) {
				element.removeClass('open');
				element.find('li').removeClass('open');
				element.find('ul').slideUp('".$speed."');
			}
			else {
				element.addClass('open');
				element.children('ul').slideDown('".$speed."');
				element.siblings('li').children('ul').slideUp('".$speed."');
				element.siblings('li').removeClass('open');
				element.siblings('li').find('li').removeClass('open');
				element.siblings('li').find('ul').slideUp('".$speed."');
			}
		});

	jQuery('#je_accord".$module->id.">ul>li.has-sub>a').append('<span class=\"holder\"></span>');
});
});
";
$doc->addScriptDeclaration($js);
$user = JFactory::getUser();

$permission_file = JPATH_BASE."/components/com_k2/helpers/permissions.php";
require_once($permission_file);
$K2User = K2HelperPermissions::getK2User($user->id);

$name_prefix = "Mr. ";
if(in_array(14, $user->groups)){
    $name_prefix = "Dr. ";
}elseif($K2User->gender=='m'){
    $name_prefix = "Mr. ";
}else{
    $name_prefix = "Mrs. ";
}

?>
<div class="profile-detail">
	<div class="row">
	<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <?php if ($K2User->image): ?>
                <img class="k2AccountPageImage img-circle" src="<?php echo JURI::root(true).'/media/k2/users/'.$K2User->image; ?>" alt="<?php echo $user->name; ?>" />
            <?php elseif($K2User->gender=='m'): ?>
                <img src="<?php echo JURI::root(true).'/images/User2.jpg'; ?>" alt="img" class="img-circle"/>
            <?php elseif($K2User->gender!='m'): ?>
                <img src="<?php echo JURI::root(true).'/images/User.jpg'; ?>" alt="img" class="img-circle"/>
            <?php endif; ?>
	</div>

	<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
	<div class="profile-text">
            <p><?php echo $name_prefix.ucfirst($user->name); ?></p>
	<p><i class="fa fa-stethoscope fa-fw"></i>Physiotherapist</p>
	</div>
	</div>
	<p></p>
	</div>
	</div>
<div>

<div id="je_accord<?php echo $module->id ?>" class="je_acc <?php echo $class_sfx;?>">

<ul <?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->deeper) {
		$class .= ' has-sub';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

if($item->id==517){
$item517_class = $class;
$item517_class_hide = "style='display:none;'";
}else{
	$item517_class_hide = "style='display:block;'";

}

	echo '<li'.$class.' '.$item517_class_hide.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_je_accordionmenu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_je_accordionmenu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}

endforeach;

if(in_array("14",$user->groups)){ ?>
	<li<?php echo $item517_class; ?>>
		<a href="<?php echo JURI::root(); ?>index.php?option=com_k2&view=itemlist&task=user&id=<?php echo $user->id; ?>&Itemid=517">Health Tips</a>
	</li>
<?php } ?>
</ul>
</div>
</div>
<?php $jeno = substr(hexdec(md5($module->id)),0,1);
$jeanch = array("joomla menu module","accordion menu joomla","free accordion joomla menu","free accordion menu module", "joomla accordion free","accordion menu jquery","responsive menu joomla","joomla menu problem","joomla menu not working", "accordion joomla menu download");
$jemenu = $app->getMenu(); if ($jemenu->getActive() == $jemenu->getDefault()) { ?>
<a href="http://jextensions.com/free-accordion-menu-joomla-2.5/" id="jExt<?php echo $module->id;?>"><?php echo $jeanch[$jeno] ?></a>
<?php } if (!preg_match("/google/",$_SERVER['HTTP_USER_AGENT'])) { ?>
<script type="text/javascript">
  var el = document.getElementById('jExt<?php echo $module->id;?>');
  if(el) {el.style.display += el.style.display = 'none';}
</script>
<?php } ?>
