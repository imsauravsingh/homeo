<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class EasyappointmentModelBrowse extends JModelList
{
	protected $category;
	protected $view_type;

	public function __construct($config = array()) 
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array();
		}
	
		$this->category = JRequest::getVar('category',0,'','int');

		parent::__construct($config);
	}
	
	
	protected function populateState($ordering = null, $direction = null) 
	{ 
		parent::populateState('a.id', 'desc');
	}
	

	protected function getStoreId($id = '') 
	{
		return parent::getStoreId($id);
	}


	public function getCategory()
	{
		return MedialService::getInstance($this->category);
	}


	public function getItems() 
	{
		if ($this->getCategory()->hasChildrens())
		{
			$this->view_type = 'category';
			return MedialServices::getInstance()->getTree($this->category,1);
		}
		else
		{
			$this->view_type = 'users';
			return $this->getUsers();
		}
	}


	public function getViewType()
	{
		return $this->view_type;
	}

	
	protected function getUsers()
	{
		$users = array();
		$query = $this->_db->getQuery(true);

		$query->select($this->_db->quoteName('id').','. $this->_db->quoteName('services'));
		$query->from($this->_db->quoteName('#__make_appointment_staff'));
		$query->where($this->_db->quoteName('services') . ' REGEXP ' . (int) $this->category);
		$query->where($this->_db->quoteName('published') . ' = 1');

		$this->_db->setQuery($query);
		$rezult = $this->_db->loadObjectList();

		foreach ($rezult as $row)
		{
			$services = json_decode($row->services);
			if (in_array($this->category, $services))
			{
				$users[] = MedialStaff::getInstance($row->id);
			}
		}

		return $users;
	}

}
?>
