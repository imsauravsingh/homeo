<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialServices 
{
	
	private static $instance;
	private $record;


	/**
	 *	@param 	array $record 		db services records 
	 *
	 */
	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			self::$instance = new MedialServices();
		}
		return self::$instance;
	}


	private function __construct()
	{
		$this->record = $this->getStoredServices();
	}

	
	/**
	 * return the services array ordered by parent
	 */
	public function getTree($key = 0, $limit_level = 0) 
	{
		$chain = $this->createConnectionParentSon();
		$this->createTree($chain,$key,$tree,0,$limit_level);
		return $tree;
	}


	/** 
	 * create the array ordered by parent
	 */
	private function createTree($arr,$key,&$rez,$level = 0,$limit_level)
	{
		if ($limit_level && $limit_level == $level)
		{
			return;
		}
		if(in_array($key, $arr))
		{
			$keys = array_keys($arr,$key);
			$level += 1;
			foreach ($keys as $k)
			{
				// if the value is in the array, it means someone has this value as parent
				$this->record[$k]->hasChildren = (in_array($k, $arr)) ? 1 : 0;
				$this->record[$k]->level = $level;
				$rez[] = new MedialService($this->record[$k]);
				$this->createTree($arr,$k,$rez,$level,$limit_level);
			}
		}
	}


	/**
	 * create an array with keys the service id and value the service parent
	 * $array[$service->id] = $serice->parent
	 */
	private function createConnectionParentSon()
	{
		$rel = array();
		foreach ($this->record as $rec)
		{
			$rel[$rec->id] = $rec->parent;
		}
		return $rel;
	}


	private function getStoredServices()
	{
		$db = JFactory::getDbo();
		$list = array();

		$query = $db->getQuery(true);
		$query->select('id, name, description, parent, price, ordering, length');
		$query->from('#__make_appointment_services');
		$query->where('published = 1');
		$query->order('parent ASC');

		$db->setQuery($query);
		$records = $db->loadObjectList();

		foreach ($records as $record) 
		{
			$list[$record->id] = $record;
		}
		return $list;
	}


}
