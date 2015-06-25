<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests;


use app\base\Routes;

class RoutesTest extends \PHPUnit_Framework_TestCase {

	public function testRoutes()
	{
		// Controller, method name, params params params
		$routes = new Routes();

		$result = $routes->process(array('test', 'test'));

		$this->assertEquals('test', $result);
	}
}
