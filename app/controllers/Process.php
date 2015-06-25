<?php
/**
 * Controller to receive the messages
 *
 * @author: Djenad Razic
 */

namespace app\controllers;

use app\common\ProcessManager;

class Process {

	/**
	 * Get process list
	 *
	 * @author Djenad Razic
	 */
	public function getList()
	{
		$manager = new ProcessManager();

		$list = json_encode($manager->getProcessList());

		echo $list;
	}

	/**
	 * Close process
	 *
	 * @param $pid
	 * @author Djenad Razic
	 */
	public function close($pid)
	{
		$manager = new ProcessManager();

		$manager->closeProcess($pid);
	}

	/**
	 * Start all services
	 *
	 * @author Djenad Razic
	 */
	public function startAll()
	{
		$manager = new \app\common\ProcessManager();

		if (count($manager->getProcessList()) > 0)
			return;

		// This receiver will dispatch the WebSocket processor and act as interaction between
		// the Redis messages and WebSocket client
		//$manager->addProcess('MessageDispatcher');

		// Spawn the message processor to retrieve the messages from Redis and dispatch it to the WebSockets mediator
		//$manager->addProcess('MessageProcessor');

		// Spawn the web socket controller process
		$manager->addProcess('WebSocketController');
	}
}