<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2014 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 3/06/2014
# ------------------------------------------------------------------------
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.filter.output');

class modTriggerMenuHelper 
{

    static function getList(&$params) {
            $app = JFactory::getApplication();
            $menu = $app->getMenu();

            // If no active menu, use default
            $active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();

            $user = JFactory::getUser();
            $levels = $user->getAuthorisedViewLevels();
            asort($levels);
            $key = 'menu_items'.$params.implode(',', $levels).'.'.$active->id;
            $cache = JFactory::getCache('mod_za_trigger_menu', '');
            if (!($items = $cache->get($key)))
            {
                    // Initialise variables.
                    $list		= array();
                    // $db		= JFactory::getDbo();

                    $path		= $active->tree;
                    $start		= (int) $params->get('startLevel');
                    $end		= (int) $params->get('endLevel');
                    $showAll	= $params->get('showAllChildren');
                    $items 		= $menu->getItems('menutype', $params->get('menutype'));

                    $lastitem	= 0;

                    if ($items) {
                            foreach($items as $i => $item)
                            {
                                    if (($start && $start > $item->level)
                                            || ($end && $item->level > $end)
                                            || (!$showAll && $item->level > 1 && !in_array($item->parent_id, $path))
                                            || ($start > 1 && !in_array($item->tree[$start-2], $path))
                                    ) {
                                            unset($items[$i]);
                                            continue;
                                    }

                                    $item->deeper = false;
                                    $item->shallower = false;
                                    $item->level_diff = 0;

                                    if (isset($items[$lastitem])) {
                                            $items[$lastitem]->deeper		= ($item->level > $items[$lastitem]->level);
                                            $items[$lastitem]->shallower	= ($item->level < $items[$lastitem]->level);
                                            $items[$lastitem]->level_diff	= ($items[$lastitem]->level - $item->level);
                                    }

                                    $item->parent = (boolean) $menu->getItems('parent_id', (int) $item->id, true);

                                    $lastitem			= $i;
                                    $item->active		= false;
                                    $item->flink = $item->link;

                                    switch ($item->type)
                                    {
                                            case 'separator':
                                                    // No further action needed.
                                                    continue;

                                            case 'url':
                                                    if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
                                                            // If this is an internal Joomla link, ensure the Itemid is set.
                                                            $item->flink = $item->link.'&Itemid='.$item->id;
                                                    }
                                                    break;

                                            case 'alias':
                                                    // If this is an alias use the item id stored in the parameters to make the link.
                                                    $item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
                                                    break;

                                            default:
                                                    $router = JSite::getRouter();
                                                    if ($router->getMode() == JROUTER_MODE_SEF) {
                                                            $item->flink = 'index.php?Itemid='.$item->id;
                                                    }
                                                    else {
                                                            $item->flink .= '&Itemid='.$item->id;
                                                    }
                                                    break;
                                    }

                                    if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
                                            $item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
                                    }
                                    else {
                                            $item->flink = JRoute::_($item->flink);
                                    }

                                    $item->title = htmlspecialchars($item->title);
                                    $item->anchor_css = htmlspecialchars($item->params->get('menu-anchor_css', ''));
                                    $item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''));
                                    $item->menu_image = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', '')) : '';
                            }

                            if (isset($items[$lastitem])) {
                                    $items[$lastitem]->deeper		= (($start?$start:1) > $items[$lastitem]->level);
                                    $items[$lastitem]->shallower	= (($start?$start:1) < $items[$lastitem]->level);
                                    $items[$lastitem]->level_diff	= ($items[$lastitem]->level - ($start?$start:1));
                            }
                    }

                    $cache->store($items, $key);
            }
            return $items;
    }
        
    static function getComponentLink($item) {
        $class = $item->anchor_css ? 'class="'.$item->anchor_css.'" ' : '';
        $title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
        if ($item->menu_image) {
                        $item->params->get('menu_text', 1 ) ?
                        $linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
                        $linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
        }
        else { $linktype = $item->title;
        }

        switch ($item->browserNav) :
                
                case 0:
                       // $item->flink;$title;$linktype;
                        //break;
                case 1:
                        // _blank
                        //break;
                case 2:
                        // window.open
                        // onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;"
                default:
                       //$item->flink;$title;$linktype; 
                    $result = array($item->title,$item->flink,$class);
                       break;
        endswitch;
        return $result;
  }
  
  static function getUrlLink($item) {
        //в классе содержится "item-153 active
        $class = $item->anchor_css ? 'class="'.$item->anchor_css.'" ' : '';
        $title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
        if ($item->menu_image) {
                        $item->params->get('menu_text', 1 ) ?
                        $linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
                        $linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
        }
        else { $linktype = $item->title;
        }
        $flink = $item->flink;
        $flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

        switch ($item->browserNav) :

                case 0:
                case 1:
                        // _blank
                case 2:
                       
                default:
                        $result = array($item->title,$flink,$class);
                        break;
        endswitch;
        return $result;
    }
  
    static function getSeparatorLink($item) {
            $title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
            if ($item->menu_image) {
                            $item->params->get('menu_text', 1 ) ?
                            $linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
                            $linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
            }
            else { $linktype = $item->title;
            }

           return NULL;
    }
    
    static function SetScript($loadJQuery) {
        $document = JFactory::getDocument();
        if ($loadJQuery) $document->addScript( 'http://code.jquery.com/jquery-1.9.1.js' );
        $document->addScriptDeclaration( "jQuery.noConflict();");
       
    }
 static function SetCSS() {
        $document = JFactory::getDocument();
        $document->addStyleSheet( 'modules/mod_za_trigger_menu/css/style.css' );
    }
    
}