<?php
/**
 * @author: Djenad Razic
 */

namespace app\base;

class Config
{
	// Processes path
	public $process_path = 'message_service';

	// Redis configuration
	public $redis_server = array(
		'host' => '127.0.0.1',
		'port' => 6379,
		'database' => 15,
		// No timeout
		'read_write_timeout' => 0
	);

	// Configuration for Web Socket
	public $socket_host = 'localhost';

	// Port for Web Socket
	public $socket_port = '6737';

	// Port for web socket controller
	public $socket_controller_port = '3767';

	// Base path name
	public $base_folder = "MessageProcessor";

	/**
	 * Get base path
	 *
	 * @author Djenad Razic
	 */
	public function getBasePath()
	{
		$path = explode('/', __DIR__);

		$dir = array_search($this->base_folder, $path);

		return implode('/', array_slice($path, 0, $dir + 1));
	}
}