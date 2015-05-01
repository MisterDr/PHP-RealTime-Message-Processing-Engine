<?php
/**
 * @author: Djenad Razic
 */

namespace app\services;

use app\base\Config;
use app\common\WebSocketServer;

class MessageDispatcher extends WebSocketServer {

	/**
	 * Construct the message dispatcher
	 * Basically this will load WebSocket from PubSub message processor
	 */
	public function __construct()
	{
		$configuration = new Config();
		// Configure socket server
		parent::__construct($configuration->socket_host, $configuration->socket_port);

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
		// Broadcast the message except the sender
		foreach ($this->users as $connected_user)
		{
			if ($user != $connected_user)
			{
				$this->send($connected_user, $msg);
			}
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