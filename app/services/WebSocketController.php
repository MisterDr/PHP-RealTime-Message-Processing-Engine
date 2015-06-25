<?php
/**
 * Web socket controller which serves requests through WebSockets
 *
 * @author: Djenad Razic
 */

namespace app\services;

use app\base\Config;
use app\base\Routes;
use app\common\WebSocketServer;


class WebSocketController extends WebSocketServer {

	/**
	 * Construct the message dispatcher
	 * This will start for listening web socket requests from client, passing it at the appropriate controller
	 */
	public function __construct()
	{
		$configuration = new Config();
		// Configure socket server
		parent::__construct($configuration->socket_host, $configuration->socket_controller_port);

		// Run the server
		$this->run();
	}

	/**
	 * Process the messages
	 *
	 * @param $user
	 * @param $msg
	 * @author Djenad Razic
	 */
	function process($user, $msg)
	{
		try
		{
			// Load controller and parameters info
			$message = explode('/', $msg);

			// Load router and process request
			$routes = new Routes();
			$data = $routes->process($message);

			// Add context (This could be more expandable as it will be over the time)
			$result = json_encode(array("context" => $msg, "message" => $data));

			// Return processed result
			$this->send($user, $result);
		}
		catch (\Exception $ex)
		{
			//TODO: Fancy exception
		}
	}

	protected function connected($user)
	{
		// DO Nothing we are only passing the message
	}

	protected function closed($user)
	{
		// DO Nothing let the connection close
	}
}