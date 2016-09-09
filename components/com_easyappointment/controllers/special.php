<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class EasyappointmentControllerSpecial extends JControllerLegacy {

	public function addNew()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_easyappointment&view=special', false));
		return true;
	}

	public function addNewRecord()
	{
		JSession::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));	
		$info = JRequest::getVar('info', array(), '', 'array');

		if ($info)
		{
			$info = $this->cleanData($info);
			$schedule = MedialStaff::getInstance($info['user'])->schedules;

			if (!$schedule) 
			{
				$record = new stdclass;
				$record->working = $info['state'];
				$record->intervals = $info['intervals'];
				$records[$info['date']] = $record;
				$row = serialize($records);
			}
			else 
			{
				$records = unserialize($schedule);
				if(isset($records[$info['date']]))
				{
					unset($records[$info['date']]);
				}
				$record = new stdclass;
				$record->working = $info['state'];
				$record->intervals = $info['intervals'];
				$records[$info['date']] = $record;
				$row = serialize($records);
			}

			MedialStaff::getInstance($info['user'])->store('schedules', $row);
		}
		exit(0);
	}


	protected function cleanData($info)
	{
		if(isset($info['date']))
		{
			preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $info['date'],$matches);
			$info['date'] = $matches[0];
		}

		if (isset($info['state']))
		{
			$info['state'] = (int) $info['state'];
		}

		if (isset($info['user']))
		{
			$info['user'] = (int) $info['user'];
		}

		if (!empty($info['intervals']))
		{
			$intervals = json_decode($info['intervals']);
			foreach ($intervals as $key=>$interval)
			{
				$interv[$key]['start'] = (int) $intervals[$key]->start;
				$interv[$key]['end'] = (int) $intervals[$key]->end;
			}
			$info['intervals'] = $interv;
		}
		else 
		{
			$info['intervals'] = array();
		}

		return $info;
	}

}

?>
