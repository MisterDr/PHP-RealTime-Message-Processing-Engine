<?php
/**
 * Simple CURL file downloader
 *
 * @author: Djenad Razic
 */

namespace app\base;


use Docker\Exception;
use ZipArchive;

class Downloader {

	protected $zip_errors = array(
		0 => 'No error.',
		1 => 'Multi-disk zip archives not supported.',
		2 => 'Renaming temporary file failed.',
		3 => 'Closing zip archive failed',
		4 => 'Seek error',
		5 => 'Read error',
		6 => 'Write error',
		7 => 'CRC error',
		8 => 'Containing zip archive was closed',
		9 => 'No such file.',
		10 => 'File already exists',
		11 => 'Can\'t open file',
		12 => 'Failure to create temporary file.',
		13 => 'Zlib error',
		14 => 'Memory allocation failure',
		15 => 'Entry has been changed',
		16 => 'Compression method not supported.',
		17 => 'Premature EOF',
		18 => 'Invalid argument',
		19 => 'Not a zip archive',
		20 => 'Internal error',
		21 => 'Zip archive inconsistent',
		22 => 'Can\'t remove file',
		23 => 'Entry has been deleted'
	);

	/**
	 * Url to init the file
	 * @var string
	 */
	public $url;

	/**
	 * Pah to store file
	 * @var string
	 */
	public $path;

	/**
	 * Do not overwrite by default
	 * @var bool
	 */
	public $overwrite = FALSE;

	public function __construct($url = NULL, $path = NULL)
	{
		$this->url = $url;
		$this->path = $path;
	}

	/**
	 * Download file at the specific path
	 * TODO: Use SSL
	 *
	 * @author Djenad Razic
	 * @param bool $overwrite
	 * @return bool
	 */
	public function download($overwrite = FALSE)
	{
		if ( ! $overwrite && file_exists($this->path))
		{
			return FALSE;
		}

		// Create folder if not exists
		$folder = pathinfo($this->path, PATHINFO_DIRNAME);

		if ( ! file_exists($folder))
			mkdir($folder, 0777, TRUE);

		set_time_limit(0);

		$file = fopen($this->path, 'w+');

		$curl = curl_init( $this->url);

		// This is large file, so no timeout
		curl_setopt($curl, CURLOPT_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_FILE, $file); // write curl response to file
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($curl); // Write it
		curl_close($curl);

		return TRUE;
	}

	/**
	 * Unzip the archive
	 *
	 * @author Djenad Razic
	 */
	public function unzip()
	{
		// Load zip
		$zip = new ZipArchive();
		$result = $zip->open($this->path);

		// Get path and extract the zip
		$dir = pathinfo($this->path, PATHINFO_DIRNAME);

		if ($result === TRUE) {
			$zip ->extractTo($dir);
			$zip ->close();
		}
		else
		{
			throw new Exception($this->zip_errors[$result]);
		}
	}
}