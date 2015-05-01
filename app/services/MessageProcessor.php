<?php
/**
 * Message processor to process the messages according to the received parameters
 *
 * @author: Djenad Razic
 */

namespace app\services;

use app\base\Config;
use Predis;
use WebSocket\Client;

class MessageProcessor {

	/**
	 * Construct the message receiver
	 * Basically this will init the Redis PubSub and create the message receive loop
	 */
	public function __construct()
	{
		$configuration = new Config();

		// Create message loop and receive messages to dispatch at client
		$this->messageLoop($configuration);
	}

	/**
	 * Create message receiver
	 *
	 * @param $configuration Config
	 * @author Djenad Razic
	 */
	protected function messageLoop($configuration)
	{
		$client = new Predis\Client($configuration->redis_server);

		// Initialize a new publish/subscribe Redis receiver
		$pubsub = $client->pubSubLoop();

		// Subscribe to your channels and loop through the messages
		$pubsub->subscribe('control_channel', 'messages');

		// Initialize the WebSocket client
		$dispatcher_client = new Client("ws://{$configuration->socket_host}:{$configuration->socket_port}");

		foreach ($pubsub as $message)
		{
			switch ($message->kind)
			{
				// Received message from PubSub
				case 'message':

					switch($message->channel)
					{
						case 'messages':

							// Send the message to the dispatcher
							$dispatcher_client->send($message->payload);

							break;

						case 'control_channel':

							// Stop listening and exit loop
							if ($message->payload == 'exit_receiver')
							{
								$pubsub->unsubscribe();
							}

							break;
					}

					break;
			}
		}

		unset($pubsub);
	}
}