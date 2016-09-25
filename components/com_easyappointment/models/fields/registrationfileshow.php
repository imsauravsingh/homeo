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

class JFormFieldRegistrationfileshow extends JFormField
{

	public function getInput()
	{
    //JHTML::_('behavior.modal');
    $imagescript = "
    jQuery(window).ready(function() {
    jQuery('.removeRegistrationImage').on('click',function(){
    var delete_id = this.id;
    jQuery.get('".JURI::root()."/index.php?option=com_easyappointment&task=settings.deleteclinicimages&tmpl=component',{delete_id:delete_id},function(data){
    if(data){
    var delete_id = parseInt(data);
      jQuery('div#divregistration_file_'+delete_id).remove();
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
    $query->select($db->quoteName(array('id', 'attachment', 'attachment_name', 'created_at')));
    $query->from($db->quoteName('#__clinic_images_attachment'));
    $query->where($db->quoteName('user_id') . '='. $db->quote($user->id));
    $query->where($db->quoteName('attachment') . '!=""');
    $query->order('created_at DESC');

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    // Load the results as a list of stdClass objects (see later for more options on retrieving data).
    $results = $db->loadObjectList();

    //echo "<pre>";
    //print_r($results); die;

    $html ='<div class="main_divregistration_filediv">';
    if(count($results)){
      foreach ($results as $key => $value) {
        if(file_exists(JPATH_SITE.DS.'images'.DS.'doctor_attachment'.DS.$user->id.DS.$value->clinic_image)){
          $html .= '<div class="divregistration_file" id="divregistration_file_'.$value->id.'"><a class="showattachmentname" rel="{handler: iframe, size: {x: 600, y: 450}}" href="'.JURI::root().'index.php?option=com_easyappointment&task=settings.showattachment&tmpl=component&file_path='.JURI::root().'images'.DS.'doctor_attachment'.DS.$user->id.DS.$value->attachment.'">'.$value->attachment_name.'</a><span class="removeRegistrationImage" id="'.$value->id.'">Delete</span></div>';

        }
      }
    }
    $html .="</div>";

    return $html;
	}

}
