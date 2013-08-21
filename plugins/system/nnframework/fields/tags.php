<?php
/**
 * Element: Tags
 * Displays a select box of backend group levels
 *
 * @package         NoNumber Framework
 * @version         13.6.10
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once JPATH_PLUGINS . '/system/nnframework/helpers/text.php';

class JFormFieldNN_Tags extends JFormField
{
	public $type = 'Tags';

	protected function getInput()
	{
		$this->params = $this->element->attributes();

		$size = (int) $this->def('size');

		$attribs = 'class="inputbox"';

		$options = $this->getTags();

		require_once JPATH_PLUGINS . '/system/nnframework/helpers/html.php';
		return nnHtml::selectlist($options, $this->name, $this->value, $this->id, $size, 1, $attribs);
	}

	protected function getTags()
	{
		// Get a database object.
		$db = JFactory::getDBO();

		// Get the user groups from the database.
		$query = $db->getQuery(true)
			->select('a.id as value, a.title as text, a.parent_id AS parent')
			->from('#__tags AS a')
			->select('COUNT(DISTINCT b.id) - 1 AS level')
			->join('LEFT', '#__tags AS b ON a.lft > b.lft AND a.rgt < b.rgt')
			->where('a.alias <> ' . $db->quote('root'))
			->group('a.id')
			->order('a.lft ASC');
		$db->setQuery($query);
		$options = $db->loadObjectList();

		return $options;
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
