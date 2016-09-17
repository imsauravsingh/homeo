<?php
/*
 * @component Easyappointment
 * @website : ionutlupu.me
 * @copyright  Ionut Lupu. All rights reserved.
 * @license : http://www.gnu.org/copyleft/gpl.html GNU/GPL , see license.txt
 */
 
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldServices extends JFormField
{

	public function getInput() 
	{	
		$user = MedialStaff::getInstance();
		$services = MedialServices::getInstance()->getTree();
		$selectedServices = $user->services ? json_decode($user->services) : array();
		$prices = $user->getParams()->get('prices');
		$service_length = $user->getParams()->get('service_length');

		$html = '';
		
		if ($services) 
		{
			foreach ($services as $service)
			{
				// if last level, staff can select the service
				if (!$service->hasChildren) 
				{
					$price = isset($prices->{$service->id}) ? $prices->{$service->id} : $service->price;
					$length = isset($service_length->{$service->id}) ? $service_length->{$service->id} : $service->length;

					$html .= '<div class="col-md-12 well well-sm">';
					$html .= '	<div class="col-md-1">
								<input type="checkbox" '.$this->checked($selectedServices,$service->id).' name="'.$this->name.'[]" class="'.$this->element['class'].'" value="'.$service->id.'"></div>';

					$html .= '<div class="col-md-5"><p> |' . str_repeat(' __ ', $service->level)  . ' ' . $service->name . '</p></div>';

					$html .= '<div id="price_'.$service->id.'" class="hidden col-md-6">';
					$html .= '<div class="pull-left"><p>'.JText::_('COM_EASYAPPOINTMENT_PRICE').'</p><input type="text" class="input-sm service-price" name="service_price['.$service->id.']" value="'. $price .'" /></div>';
					$html .= '<div class="pull-left"><p>'.JText::_('COM_EASYAPPOINTMENT_LENGTH').'</p>'.$this->getLengths($service->id,$length).'</div>';
					$html .= '</div>';

					$html .= '</div>';
				}
				else
				{
					$html .= '<div class="col-md-12 well well-sm">';
					$html .= '<div class="col-md-offset-1 col-md-11"><p> |' . str_repeat(' __ ', $service->level)  . ' ' . $service->name . '</p></div>';
					$html .= '</div>';
				}
			}
		}
		return $html;
	} 


	protected function getLengths($service,$length)
	{
		$html = '<select class="input-sm" name="service_length['.$service.']">';
		for ($i=5;$i<=360;$i+=5) 
		{
			$extra = ($i == $length) ? 'selected="selected"' : '';
			$html .= '<option '.$extra.' value="'.$i.'">'.$i.' '. JText::_('COM_EASYAPPOINTMENT_MINUTES') . '</option>';
		}
		$html .= '</select>';

		return $html;
	}


	protected function checked($services,$id)
	{
		if (in_array($id, $services))
		{
			return 'checked="checked"';
		}
		return '';
	}
	
}
