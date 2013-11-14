<?php
/**
 * Installer File
 * Performs an install / update of NoNumber extensions
 *
 * @package         NoNumber Installer
 * @version         13.11.11
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2013 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

define('ROOT', dirname(__FILE__));

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

$class = new com_NoNumberInstallerInstallerScript;
$class->preflight();

class com_NoNumberInstallerInstallerScript
{
	protected $_ext = 'nonumberinstaller';

	public function preflight()
	{
		// Install the Installer languages
		self::installLanguages(ROOT . '/language', 1, 0);

		// Load language for messaging
		if (JFactory::getLanguage()->getTag() != 'en-GB')
		{
			// Loads English language file as fallback (for undefined stuff in other language file)
			JFactory::getLanguage()->load('com_' . $this->_ext, JPATH_ADMINISTRATOR, 'en-GB');
		}
		JFactory::getLanguage()->load('com_' . $this->_ext, JPATH_ADMINISTRATOR, null, 1);

		JFactory::getApplication()->enqueueMessage(JText::sprintf('NNI_NOT_COMPATIBLE_OLD', implode('.', array_slice(explode('.', JVERSION), 0, 2))), 'error');
		self::cleanup();
	}

	/**
	 * Copies language files to the language folders
	 */
	private function installLanguages($folder, $force = 1, $all = 1, $break = 1)
	{
		if (JFolder::exists($folder . '/admin'))
		{
			$path = JPATH_ADMINISTRATOR . '/language';
			if (!self::installLanguagesByPath($folder . '/admin', $path, $force, $all, $break) && $break)
			{
				return 0;
			}
		}
		if (JFolder::exists($folder . '/site'))
		{
			$path = JPATH_SITE . '/language';
			if (!self::installLanguagesByPath($folder . '/site', $path, $force, $all, $break) && $break)
			{
				return 0;
			}
		}
		return 1;
	}

	/**
	 * Copies language files to the specified path
	 */
	private function installLanguagesByPath($folder, $path, $force = 1, $all = 1, $break = 1)
	{
		if ($all)
		{
			$languages = JFolder::folders($path);
		}
		else
		{
			$lang = JFactory::getLanguage();
			$languages = array($lang->getTag());
		}
		$languages[] = 'en-GB'; // force to include the English files
		$languages = array_unique($languages);

		if (JFolder::exists($path . '/en-GB'))
		{
			self::folder_create($path . '/en-GB');
		}

		foreach ($languages as $lang)
		{
			if (!JFolder::exists($folder . '/' . $lang))
			{
				continue;
			}
			$files = JFolder::files($folder . '/' . $lang);
			foreach ($files as $file)
			{
				$src = $folder . '/' . $lang . '/' . $file;
				$dest = $path . '/' . $lang . '/' . $file;
				if (!(strpos($file, '.menu.ini') === false))
				{
					if (JFile::exists($dest))
					{
						JFile::delete($dest);
					}
					continue;
				}
				if ($force || JFile::exists($src))
				{
					if (!JFile::copy($src, $dest) && $break)
					{
						return 0;
					}
				}
			}
		}
		return 1;
	}

	private function cleanup()
	{
		self::cleanupInstall();
		self::uninstallInstaller();
	}

	/**
	 * Cleanup install files/folders
	 */
	private function cleanupInstall()
	{
		$installer = JInstaller::getInstance();
		$source = str_replace('\\', '/', $installer->getPath('source'));
		$config = JFactory::getConfig();
		$tmp = dirname(str_replace('\\', '/', $config->getValue('config.tmp_path') . '/x'));

		if (strpos($source, $tmp) === false || $source == $tmp)
		{
			return;
		}

		$package_folder = dirname($source);
		if ($package_folder == $tmp)
		{
			$package_folder = $source;
		}

		$package_file = '';
		switch (JRequest::getString('installtype'))
		{
			case 'url':
				$package_file = JRequest::getString('install_url');
				$package_file = str_replace(dirname($package_file), '', $package_file);
				break;
			case 'upload':
			default:
				if (isset($_FILES) && isset($_FILES['install_package']) && isset($_FILES['install_package']['name']))
				{
					$package_file = $_FILES['install_package']['name'];
				}
				break;
		}
		if (!$package_file && $package_folder != $source)
		{
			$package_file = str_replace($package_folder . '/', '', $source) . '.zip';
		}

		$package_file = $tmp . '/' . $package_file;

		JInstallerHelper::cleanupInstall($package_file, $package_folder);
	}

	private function uninstallInstaller()
	{
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();

		$query = 'SELECT `id` FROM `#__components`'
			. ' WHERE `option` = ' . $db->quote('com_' . $this->_ext)
			. ' AND `parent` = 0'
			. ' LIMIT 1';
		$db->setQuery($query);
		$id = (int) $db->loadResult();
		if ($id > 1)
		{
			$installer = JInstaller::getInstance();
			$installer->uninstall('component', $id);
		}
		$query = 'ALTER TABLE `#__components` AUTO_INCREMENT = 1';
		$db->setQuery($query);
		$db->query();

		// Delete language files
		$lang_folder = JPATH_ADMINISTRATOR . '/language';
		$languages = JFolder::folders($lang_folder);
		foreach ($languages as $lang)
		{
			$file = $lang_folder . '/' . $lang . '/' . $lang . '.com_' . $this->_ext . '.ini';
			if (JFile::exists($file))
			{
				JFile::delete($file);
			}
		}

		// Delete old language files
		$files = JFolder::files(JPATH_SITE . '/language', 'com_' . $this->_ext . '.ini');
		foreach ($files as $file)
		{
			JFile::delete(JPATH_SITE . '/language/' . $file);
		}

		// Redirect with message
		$app->redirect('index.php?option=com_installer');
	}

	/**
	 * Create a folder
	 */
	private function folder_create($path = '', $mode = 0755)
	{
		// Initialize variables
		jimport('joomla.client.helper');
		$ftpOptions = JClientHelper::getCredentials('ftp');

		// Check to make sure the path valid and clean
		$path = JPath::clean($path);

		// Check if dir already exists
		if (JFolder::exists($path))
		{
			return true;
		}

		// Check for safe mode
		if ($ftpOptions['enabled'] == 1)
		{
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = JFTP::getInstance(
				$ftpOptions['host'], $ftpOptions['port'], array(),
				$ftpOptions['user'], $ftpOptions['pass']
			);

			// Translate path to FTP path
			$path = JPath::clean(str_replace(JPATH_ROOT, $ftpOptions['root'], $path), '/');
			$ret = $ftp->mkdir($path);
			$ftp->chmod($path, $mode);
		}
		else
		{
			// We need to get and explode the open_basedir paths
			$obd = ini_get('open_basedir');

			// If open_basedir is set we need to get the open_basedir that the path is in
			if ($obd != null)
			{
				if (JPATH_ISWIN)
				{
					$obdSeparator = ";";
				}
				else
				{
					$obdSeparator = ":";
				}
				// Create the array of open_basedir paths
				$obdArray = explode($obdSeparator, $obd);
				$inBaseDir = false;
				// Iterate through open_basedir paths looking for a match
				foreach ($obdArray as $test)
				{
					$test = JPath::clean($test);
					if (strpos($path, $test) === 0)
					{
						$inBaseDir = true;
						break;
					}
				}
				if ($inBaseDir == false)
				{
					// Return false for JFolder::create because the path to be created is not in open_basedir
					JError::raiseWarning(
						'SOME_ERROR_CODE',
						'JFolder::create: ' . JText::_('NNI_PATH_NOT_IN_OPEN_BASEDIR_PATHS')
					);
					return false;
				}
			}

			// First set umask
			$origmask = @umask(0);

			// Create the path
			if (!$ret = @mkdir($path, $mode))
			{
				@umask($origmask);
				return false;
			}

			// Reset umask
			@umask($origmask);
		}

		return $ret;
	}
}
