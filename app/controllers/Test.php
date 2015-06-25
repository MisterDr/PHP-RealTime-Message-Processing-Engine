<?php
/**
 * Controller to receive the messages
 *
 * @author: Djenad Razic
 */

namespace app\controllers;

use app\base\Config;
use app\common\ProcessManager;
use League\Plates\Engine;

class Test {

	/**
	 * Get test data
	 *
	 * @author Djenad Razic
	 */
	public function test()
	{
		//echo "test";
		return "test";
	}

	/**
	 * Test simple view
	 *
	 * @author Djenad Razic
	 */
	public function getLoginView()
	{
		$config = new Config();
		$path = $config->getBasePath() . '/app/views/upload/';

		$templates = new Engine($path);
		return $templates->render('login');
	}

	/**
	 * TODO: Extend plates to use theirs FS
	 *
	 * @author Djenad Razic
	 * @return string
	 */
	public function getLoginViewRemoteFS()
	{
		$config = new Config();
		$path = $config->getBasePath() . '/app/views/upload/';

		$templates = new Engine($path);
		return $templates->render('login');
	}
}