<?php
/**
 * Element: MenuItems
 * Display a menuitem field with a button
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

class JFormFieldNN_MenuItems extends JFormField
{
	public $type = 'MenuItems';

	protected function getInput()
	{
		$size = (int) $this->def('size');
		$multiple = $this->def('multiple', 1);

		require_once JPATH_ADMINISTRATOR . '/components/com_menus/helpers/menus.php';
		$options = MenusHelper::getMenuLinks();
		require_once JPATH_PLUGINS . '/system/nnframework/helpers/html.php';
		foreach($options as $i => $option) {
			$options[$i]->value = 'type.'.$option->menutype;
			$options[$i]->text = $option->title;
			$options[$i]->level = 0;
			$options[$i]->class = 'hidechildren';
			$options[$i]->labelclass = 'nav-header';
			unset($option->title);
		}
		return nnHtml::selectlist($options, $this->name, $this->value, $this->id, $size, $multiple);
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
