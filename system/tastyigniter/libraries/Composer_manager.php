<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Composer_manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Composer_manager.php
 * @link           http://docs.tastyigniter.com
 */
class Composer_manager
{
	const INSTALLER_URL = 'https://getcomposer.org/composer.phar';
	const EXTRACTED_PHAR = 'extracted_phar';
	const COMPOSER_PHAR = 'composer.phar';

	public $vendorDir;
	public $checkPaths = ['vendor', 'vendor/composer', 'vendor/illuminate', 'vendor/autoload.php'];

	public function checkVendor()
	{
		$vendorDir = $this->getVendorRootDir();
		foreach ($this->checkPaths as $path) {
			if (!file_exists($vendorDir .DIRECTORY_SEPARATOR. $path))
				return FALSE;
		}

		return TRUE;
	}

	public function makeComposer()
	{
		if ($this->downloadComposer())
			$this->extractComposer();

		if (!$this->checkVendor())
			$this->command('install');

		$this->cleanUp();
	}

	public function command($command)
	{
		// $this->autoload();
		if (!$this->checkVendor()) {
			if (!file_exists($extractedPhar = $this->getExtractedPharPath()))
				throw new Exception("Extracted ".self::COMPOSER_PHAR." not found");

			putenv("COMPOSER_HOME={$extractedPhar}/bin/composer");
			require_once($extractedPhar . '/vendor/autoload.php');
		}

		set_time_limit(-1);
		ini_set('phar.readonly', '0');

		// Setup composer input and output formatter
		$stream = fopen('php://temp', 'w+');
		$output = new Symfony\Component\Console\Output\StreamOutput($stream);
		$input = new Symfony\Component\Console\Input\ArrayInput(['command' => $command]);

		// change out of the directory so that the vendors file is created correctly
		chdir($this->getVendorRootDir());

		// Programmatically run `composer command`
		$composerApp = new Composer\Console\Application();
		$composerApp->setAutoExit(FALSE);
		$composerApp->run($input, $output);

		rewind($stream);
		$response = trim(stream_get_contents($stream));
		log_message('debug', strip_tags($response));
	}

	public function downloadComposer()
	{
		if (is_dir($extractedPhar = $this->getExtractedPharPath()))
			return TRUE;

		if (file_exists($composerPhar = $this->getVendorRootDir(self::COMPOSER_PHAR)))
			return TRUE;

		if (!$this->checkVendor()) {
			if (!is_dir($temp_dir = ROOTPATH . 'assets/downloads/temp')) {
				mkdir($temp_dir, 0777, TRUE);
			}

			$installerStream = fopen($composerPhar, 'w+');
			get_remote_data(self::INSTALLER_URL, ['FILE' => $installerStream]);

			if (!file_exists($composerPhar)) {
				$message = "Error downloading " . self::INSTALLER_URL;
				log_message('error', $message);
				throw new Exception($message);
			}

			return TRUE;
		}

		return FALSE;
	}

	public function extractComposer()
	{
		if (is_dir($extractedPhar = $this->getExtractedPharPath()))
			return TRUE;

		$composerPhar = $this->getVendorRootDir(self::COMPOSER_PHAR);
		if (file_exists($composerPhar) AND !is_dir($extractedPhar)) {
			mkdir($extractedPhar, 0777, true);

			$composer = new Phar($composerPhar);
			//php.ini setting phar.readonly must be set to 0
			//ini_set('phar.readonly', '0');
			$composer->extractTo($extractedPhar);
			@unlink($composerPhar);

			return TRUE;
		}

		log_message('error', $composerPhar . ' does not exist');

		return FALSE;
	}

	public function getVendorRootDir($directory = null)
	{
		$vendorDir = rtrim($this->vendorDir ? $this->vendorDir : ROOTPATH, '/');

		return $directory ? $vendorDir . DIRECTORY_SEPARATOR . $directory : $vendorDir;
	}

	public function setVendorRootDir($vendorDir)
	{
		$this->vendorDir = $vendorDir;
	}

	public function getExtractedPharPath()
	{
		return $this->getVendorRootDir(self::EXTRACTED_PHAR);
	}

	public function cleanUp()
	{
		if (!function_exists('delete_files'))
			get_instance()->load->helper('file_helper');

		delete_files($this->getExtractedPharPath(), TRUE);
		@rmdir($this->getExtractedPharPath());
		@unlink($this->getVendorRootDir(self::COMPOSER_PHAR));
	}
}