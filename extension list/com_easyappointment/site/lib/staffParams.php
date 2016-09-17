<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


// Params class
class MedialStaffParams 
{
	private $form;
	private $data;
	

	/**
	 * @param 	string $data 		json encoded settings
	 */
	public function __construct($data)
	{	
		if ($data)
		{
			$this->data = json_decode($data);
		}
	}
	
	
	/**
	 *  return set value for a certain setting
	 *  in case the user doesn't have any value saved, get the default value
	 *
	 * 	@param [string] $param  	name of the setting we want to get value
	 *
	 * 	@return 					value of that setting 
	 */
	public function get($param)
	{
		if (isset($this->data->$param))
		{
			$this->$param = $this->data->$param;
		}
		else 
		{
			$this->loadDefaultXML();
			$this->bindDefaultValues();
		}
		return isset($this->$param) ? $this->$param : '';
	}


	/**
	 * load the standard xml file for settings 
	 * we need to use the default values for settings in case the user doesn't have settings saved
	 */
	protected function loadDefaultXML()
	{
		if(!$this->form) 
		{
			$this->form = JForm::getInstance('com_easyappointment.settings', JPATH_COMPONENT . '/models/forms/settings.xml');	
		}
	}


	/**
	 * bind default settings values using the xml file if no data is stored
	 */
	protected function bindDefaultValues()
	{
		foreach($this->form->getFieldsets() as $fieldset)
		{
			foreach ($this->form->getFieldset($fieldset->name) as $field)
			{	
				$this->{$field->fieldname} = $this->form->getFieldAttribute($field->fieldname,'default');
			}
		}
	}

}
?>
