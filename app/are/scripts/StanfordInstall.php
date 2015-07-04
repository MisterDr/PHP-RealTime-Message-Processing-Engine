<?php
/**
 * @author: Djenad Razic
 */

include "vendor/autoload.php";

use app\base\Config;
use app\base\Downloader;
use GuzzleHttp\Tests\Adapter\Curl\CurlAdapterTest;

class StanfordInstall {

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * Install Stanford's POS Tagger, NER Tagger
	 *
	 * @author Djenad Razic
	 */
	public static function install()
	{
		self::installPosTagger();
		self::installnerTagger();
		self::installParser();
	}

	/**
	 * Get'em boys
	 *
	 * @author Djenad Razic
	 */
	public static function installPosTagger()
	{
		self::process(Config::POS_URL, Config::POS_SAVE_PATH);
	}

	/**
	 * Get'em boys
	 *
	 * @author Djenad Razic
	 */
	public static function installNerTagger()
	{
		self::process(Config::NER_URL, Config::NER_SAVE_PATH);
	}

	/**
	 * Get'em boys
	 *
	 * @author Djenad Razic
	 */
	public static function installParser()
	{
		self::process(Config::PARSER_URL, Config::PARSER_SAVE_PATH);
	}

	/**
	 * Process with download and unzip
	 *
	 * @author Djenad Razic
	 * @param $url
	 * @param $save_path
	 * @throws \Docker\Exception
	 */
	private static function process($url, $save_path)
	{
		$downloader = new Downloader($url, $save_path);
		$downloaded = $downloader->download();

		// Unzip it
		if ($downloaded)
		{
			$downloader->unzip();
		}
	}

}

// !DUH shitty composer post install script loader
\StanfordInstall::install();