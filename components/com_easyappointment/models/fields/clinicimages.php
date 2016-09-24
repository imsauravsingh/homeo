<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

class JFormFieldClinicimages extends JFormField
{

	public function getInput()
	{

    $imagescript = "
    var $$ =jQuery.noConflict();
    $$(window).ready(function() {
    $$('.removeClinicImage').on('click',function(){
    var delete_id = this.id;
    $$.get('".JURI::root()."/index.php?option=com_easyappointment&task=settings.deleteclinicimages&tmpl=component',{delete_id:delete_id},function(data){
    if(data){
    var delete_id = parseInt(data);
      $$('div#divclinic_img_'+delete_id).remove();
    }
    });
    });
    });";

    $doc = JFactory::getDocument();
    $doc->addScriptDeclaration($imagescript);

    $user = MedialStaff::getInstance();
    // Get a db connection.
    $db = JFactory::getDbo();

    // Create a new query object.
    $query = $db->getQuery(true);

    // Select all records from the user profile table where key begins with "custom.".
    // Order it by the ordering field.
    $query->select($db->quoteName(array('id', 'clinic_image','attachment_name', 'created_at')));
    $query->from($db->quoteName('#__clinic_images_attachment'));
    $query->where($db->quoteName('user_id') . '='. $db->quote($user->id));
    $query->where($db->quoteName('clinic_image') . '!=""');
    $query->order('created_at DESC');

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    // Load the results as a list of stdClass objects (see later for more options on retrieving data).
    $results = $db->loadObjectList();

    //echo "<pre>";
    //print_r($results); die;

    $html ='<div class="main_clinic_imgdiv">';
    if(count($results)){
      foreach ($results as $key => $value) {
        if(file_exists(JPATH_SITE.DS.'images'.DS.'clinic_images'.DS.$user->id.DS.$value->clinic_image)){
          $html .= '<div class="clinic_img" id="divclinic_img_'.$value->id.'"><img style="width:50px" title="'.$value->attachment_name.'" src="'.JURI::root().DS.'images'.DS.'clinic_images'.DS.$user->id.DS.$value->clinic_image.'"><span class="removeClinicImage" id="'.$value->id.'">Delete</span></div>';
        }
      }
    }
    $html .="</div>";

    return $html;
	}

}
