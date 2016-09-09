<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Homeo
 * @author     saurav <imsauravsingh@gmail.com>
 * @copyright  2016 saurav
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Class HomeoController
 *
 * @since  1.6
 */
class HomeoController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean $cachable  If true, the view output will be cached
	 * @param   mixed   $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController   This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
        $app   = JFactory::getApplication();
        $start = $app->input->getInt('start', 0);

        if ($start == 0)
        {
            $app->input->set('limitstart', 0);
        }

        $view = $app->input->getCmd('view', 'dashboard');
		$app->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
