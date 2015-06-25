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
	}

	/**
	 * Setup the routes and process according to request data
	 *
	 * @author Djenad Razic
	 * @param string $routes Routes to determine
	 * @return mixed|null
	 */
	public function process($routes = NULL)
	{
		// Check if not user defined routes exists
		if ($routes === NULL)
		{
			// Decimate it
			// No other than REST? Well, time to keep up with time guyz
			$routes = array_reverse(explode('/', $_SERVER['REQUEST_URI']));

			// I don't like you
			array_pop($routes);
		}
		else
		{
			// Invert it
			$routes = array_reverse($routes);
		}

		// Get bare class name and try to use our controller path
		$controller_name = "app\\controllers\\" . ucwords(array_pop($routes));

		// Method YESS!
		$method = array_pop($routes);

		// Create controller instance
		$instance = new $controller_name();

		// If method exists call it
		if (method_exists($instance, $method))
		{
			return call_user_func_array(array($instance, $method), $routes);
		}

		return NULL;
	}
}