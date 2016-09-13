<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


class MedialService extends JObject
{
		private static $instance;
		public $id = 0;
		public $name = 'undefined';
		public $parent = 0;
		public $description = '';
		public $length = 0;
		public $price = 0;
		public $published = 0;
		
		
		/**
		 * @param [object] [$record] [db record for the service]
		 */
		public function __construct($record)
		{
			if (!empty($record))
			{
				$this->setProperties($record);
				if (!isset($instance[$record->id]))
				{
					$instance[$record->id] = $this;
				}
			}
		}
		
		
		public static function getInstance($id)
		{
			if(!isset(self::$instance[$id]))
			{
				$record = self::_loadRecord($id);
				self::$instance[$id] = new MedialService($record);
			}
			return self::$instance[$id];
		}
		
		
		private static function _loadRecord($id)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__make_appointment_services'));
			$query->where($db->quoteName('id') . ' = ' . (int) $id);
			
			$db->setQuery($query);
			return $db->loadObject();
		}


		public function hasChildrens()
		{
			$childrens = $this->getChildrens();
			return empty($childrens) ? 0 : 1;
		}

		
		public function getChildrens()
		{
			return MedialServices::getInstance()->getTree($this->id);
		}

}
