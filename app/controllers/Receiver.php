<?php
/**
 * Controller to receive the messages
 *
 * @author: Djenad Razic
 */

namespace app\controllers;

use app\base\Config;
use app\base\Validation;
use app\services\MessageReceiver;
use Predis;

class Receiver {

	/**
	 * @var array
	 */
	protected $validation_fields = array(
		'userId',
		'currencyFrom',
		'currencyTo',
		'amountSell',
		'amountBuy',
		'rate',
		'timePlaced',
		'originatingCountry'
	);

	/**
	 * Receive the data route
	 *
	 * @author Djenad Razic
	 */
	function receive()
	{
		if (count($_POST) == 0)
			return;

		// Validate
		$validation = new Validation($this->validation_fields);
		$validation->validate();

		// Create message receiver and process message
		$receiver = new MessageReceiver();
		$receiver->process($_POST);
	}
}