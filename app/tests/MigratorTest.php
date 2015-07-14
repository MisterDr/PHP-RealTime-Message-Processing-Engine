<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests;


use app\base\Config;
use app\base\Migrator;

class MigratorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test migrator
	 *
	 * @author Djenad Razic
	 */
	public function testCreate()
	{
		$config = new Config();

		$path = $config->getBasePath();

		$migrator = new Migrator();

		$code = $migrator->create('test');



		//$alo = eval($code);
	}
}
