<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modeladmin');

class EasyappointmentModelSettings extends JModelAdmin
{

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_easyappointment.settings', 'settings', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// display textareas as editor in case the email format is HTML (1)
		if (MedialStaff::getInstance()->getParams()->get('email_format') == 1)
		{
			$form->setFieldAttribute('send_email_body', 'type', 'editor');
			$form->setFieldAttribute('receive_email_body', 'type', 'editor');
		}

		return $form;
	}


	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_easyappointment.edit.settings.data', array());
		if (!$data)
		{
			$user = MedialStaff::getInstance();
			$data = json_decode($user->params);
		}

		return $data;
	}

  public function uploadfile($files,$filefolder){
		    $fileError=$files['error'];

		    if($fileError>0){

		        switch (true){

		            case $fileError==1:
		            echo JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );
		            return;

		            case $fileError==2:
		            echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
		            return;

		            case $fileError==3:
		            echo JText::_( 'ERROR PARTIAL UPLOAD' );
		            return;

		            case $fileError==4:
		            echo JText::_( 'ERROR NO FILE' );
		            return;

		        }
		    }

		    $filesize=$files['size'];

		    if($filesize>2000000){

		    echo JText::_( 'FILE BIGGER THAN 2MB' );

		    }

		    $fileTemp=$files['tmp_name'];
				$attachment_name = $fileName = JFile::makeSafe($files['name']);

		    $imageinfo = getimagesize($fileTemp);
/*		    $okMIMETypes = 'image/jpeg,image/jpg,image/pjpeg,image/png,image/x-png,image/gif, application/pdf, doc, docx';
		    $validFileTypes = explode(",", $okMIMETypes);

		    if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) ||  !in_array($imageinfo['mime'], $validFileTypes) )
		    {
			    echo JText::_( 'INVALID FILETYPE' );
			    return;
		    }
*/
				$filename_arr = explode(".", $fileName);

				$ext = JFile::getExt($fileName);
				$filename = strtolower($filename_arr[0].'_'.rand().'_'.mktime().'.'.$ext);

				if($filefolder){
					$uploadPath = JPATH_SITE.DS.'images'.DS.$filefolder.DS.$filename;
				}else{
					$uploadPath = JPATH_SITE.DS.'images'.DS.$filename;
				}

		    if(!JFile::upload($fileTemp, $uploadPath))
		    {
		            echo JText::_('ERROR MOVING FILEs'.$fileTemp);
		            return;
		    }
		    else
		    {
					return array("filename"=>$filename,"attachment_name"=>$attachment_name);
		    }
	}

	public function save($data)
	{
		$jinput = JFactory::getApplication()->input;
		$files = $jinput->files->get('jform','array',null);
		$user = MedialStaff::getInstance();

		// store data in session
		JFactory::getApplication()->setUserState('com_easyappointment.edit.settings.data', $data);

		// filter data before saving
		$newdata = $this->filterBeforeSave($data);


		// services should contain only integers since we are dealing with ID
		JArrayHelper::toInteger($data['service']);

		// store data in db
		MedialStaff::getInstance()->store('services',json_encode($data['service']));
		MedialStaff::getInstance()->store('params',json_encode($newdata));


		// update clinic images
		if(count($files['book_appointment']['clinic_images'])){
			$this->updateClinicImage($files['book_appointment']['clinic_images'], $user);
		}

		// update attachment file
		if(count($files['registration_file'])){
				$this->updateAttachmentFile($files['registration_file'], $user);
		}

		return true;
	}

	public function deleteimages(){
		$delete_id = JRequest::getVar('delete_id');
		$db = & JFactory::getDBO();
		$query = $db->getQuery(true);
		//$query->delete($db->nameQuote('#__clinic_images_attachment'));
		//$query->where($db->nameQuote('id').'='.$db->quote($delete_id));


		$conditions = array(
		  $db->quoteName('id') . ' = ' . $db->quote($delete_id)
		);
		$query->delete($db->quoteName('#__clinic_images_attachment'))
      ->where($conditions);
		//echo $query;  die;
		$db->setQuery($query);
		$db->query();
	}

	function updateClinicImage($data, $user){
		$filefolder = "clinic_images/".$user->id;
		$clinic_images = array();
		foreach($data as $file){
					$uploadfile = $this->uploadfile($file,$filefolder);
					if(!empty($uploadfile)){
						$clinic_images[] = array("filename"=>$uploadfile['filename'],"attachment_name"=>$uploadfile['attachment_name']);
					}
		}

		if(count($clinic_images)){

			// insert clinic images
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			// Insert columns.
			$columns = array('user_id', 'clinic_image', 'attachment_name');

			foreach($clinic_images as $cimage){
			// Insert values.
			//$values[] = array($user->id, $db->quote($cimage));
			$values[] = $user->id.", ".$db->quote($cimage['filename']).", ".$db->quote($cimage['attachment_name']);
			}
			// Prepare the insert query.
			$query
					->insert($db->quoteName('#__clinic_images_attachment'))
					->columns($db->quoteName($columns))
					->values($values);

			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();
		}

		return true;

	}

	function updateAttachmentFile($main_data, $user){
		$filefolder = "doctor_attachment/".$user->id;
		$data = array();
 		foreach($main_data as $file){
					$uploadfile = $this->uploadfile($file,$filefolder);
					if(!empty($uploadfile)){
						$data[] = array("filename"=>$uploadfile['filename'],"attachment_name"=>$uploadfile['attachment_name']);
					}
		}

		if(count($data)){
			// insert clinic images
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			// Insert columns.
			$columns = array('user_id', 'attachment', 'attachment_name');

			foreach($data as $d){
				// Insert values.
				$values[] = $user->id.", ".$db->quote($d['filename']).", ".$db->quote($d['attachment_name']) ;
			}

			// Prepare the insert query.
			$query
					->insert($db->quoteName('#__clinic_images_attachment'))
					->columns($db->quoteName($columns))
					->values($values);

			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();
		}

		return true;

	}

	/**
	 * make sure we do not save any unallowed values
	 * exclude services since this is going to saved separately
	 *
	 * @param [array] $data 		form values that should be saved
	 *
	 * @return [array] $newdata 	filtered form values
	 */
	protected function filterBeforeSave($data)
	{
		$form = $this->loadForm('com_easyappointment.settings', 'settings', array('control' => 'jform', 'load_data' => true));
		$filter = JFilterInput::getInstance();
		$newdata = array();

		foreach ($data as $key => $setting)
		{
			if ($key == 'service')
			{
				continue;
			}
			elseif ($key == 'prices')
			{
				foreach ($data[$key] as $k=>$price)
				{
					preg_match('/[0-9.]{1,}/', $price, $matches);
					$newdata[$key][$k] = isset($matches[0]) ? (float) $matches[0] : 0;
				}
			}
			elseif ($key == 'service_length')
			{
				foreach ($data[$key] as $k=>$length)
				{
					$newdata[$key][$k] = (int) $length;
				}
			}
			else
			{
				$rule = $form->getFieldAttribute($key,'xrule');
				if ($rule)
				{
					preg_match($rule, $setting, $matches);
					$newdata[$key] = isset($matches[0]) ? $matches[0] : '';
				}
				else
				{
					$newdata[$key] = $filter->clean($setting,'raw');
				}
			}
		}

		return $newdata;
	}



}
?>
