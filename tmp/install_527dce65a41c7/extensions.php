<?php
/**
 * Extension Install File
 * Does the stuff for the specific extensions
 *
 * @package         Sourcerer
 * @version         4.2.5
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2013 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

function install(&$states, &$ext)
{
	$name = 'Sourcerer';
	$alias = 'sourcerer';
	$ext = $name . ' (system plugin & editor button plugin)';

	// SYSTEM PLUGIN
	$states[] = installExtension($states, $alias, 'System - NoNumber ' . $name, 'plugin');

	// EDITOR BUTTON PLUGIN
	$states[] = installExtension($states, $alias, 'Button - NoNumber ' . $name, 'plugin', array('folder' => 'editors-xtd'));
}
