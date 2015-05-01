<?php
/**
 * Run the message dispatcher and processor
 * @note: This could be created in the React Async WebSockets and Async Redis, however it requires
 *        ext-libevent which is is adding more hassle for installation.
 *
 * @author: Djenad Razic
 */

include "vendor/autoload.php";

$process_manager = new \app\common\ProcessManager();

// This receiver will dispatch the WebSocket processor and act as interaction between
// the Redis messages and WebSocket client
$process_manager->addProcess('MessageDispatcher');

// Spawn the message processor to retrieve the messages from Redis and dispatch it to the WebSockets mediator
$process_manager->addProcess('MessageProcessor');
