<?php
/**
 * @author: Djenad Razic
 */

namespace app\services;

use Predis;
use app\base\Config;

class MessageReceiver {

	/**
	 * @var Config
	 */
	private $configuration;

	/**
	 * Construct the message receiver
	 * Basically this will init the Redis PubSub and create the message receive loop
	 */
	public function __construct()
	{
		$this->configuration = new Config();
	}

	/**
	 * Process the input message
	 *
	 * @author Djenad Razic
	 * @param $data string
	 */
	public function process($data)
	{
		// Initialize the Redis client
		$client = new Predis\Client($this->configuration->redis_server);

		// Format message
		$message = sprintf("[\"%s\", %f, %f, %f]", $data['timePlaced'] . ", " .
			$data['currencyFrom'] . "/" . $data['currencyTo'] . ", " .
			$data['originatingCountry'], $data['amountSell'], $data['amountBuy'], $data['rate']);

		$client->publish("messages", $message);
	}
}