<?php
/**
 * Route the requests via simple REST router
 *
 * @author: Djenad Razic
 */

namespace app\base;

class Routes
{
	/**
	 * @var Config
	 */
	protected $configuration;

	public function __construct()
	{
		$this->configuration = new Config();

		$this->setupRoutes();
	}

	/**
	 * Setup the routes and redirect according to request
	 *
	 * @author Djenad Razic
	 */
	protected function setupRoutes()
	{
		// Decimate it
		// No other than REST? Well, time to keep up with time guyz
		$routes = array_reverse(explode('/', $_SERVER['REQUEST_URI']));

		// I don't like you
		array_pop($routes);

		// Get bare class name and try to use our controller path
		$controller_name = "app\\controllers\\" . ucwords(array_pop($routes));

		// Method YESS!
		$method = array_pop($routes);

		// Create controller instance
		$instance = new $controller_name();

		// If method exists call it
		if (method_exists($instance, $method))
		{
			call_user_func_array(array($instance, $method), $routes);
		}
	}
}