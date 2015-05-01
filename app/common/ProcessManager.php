<?php
/**
 * Process manager to manage the started processes
 *
 * @author: Djenad Razic
 */

namespace app\common;

use app\base\Config;
use Exception;
use Predis\Client;

class ProcessManager {

	/**
	 * @var Config
	 */
	private $configuration;

	/**
	 * @var Client
	 */
	protected $redis_client;

	public function __construct()
	{
		// Load configuration
		$this->configuration = new Config();

		// Initialize the Redis client
		$this->redis_client = new Client($this->configuration->redis_server);
	}

	/**
	 * Spawn the process and add the info about it at the Redis
	 *
	 * @param ProcessSpawner $class
	 * @author Djenad Razic
	 */
	public function addProcess($class)
	{
		try
		{
			$message_processor = new ProcessSpawner($this->configuration->process_path, $class);
			$pid = $message_processor->start();

			// Add process at the list
			$this->redis_client->hset("process", $pid, $class);

		}
		catch (Exception $ex)
		{
			echo $ex->getMessage();
		}
	}

	/**
	 * Get running processes
	 *
	 * @author Djenad Razic
	 */
	public function getProcessList()
	{
		// Get all values
		return  $this->redis_client->hgetall("process");
	}

	/**
	 * Close process with specific process ID
	 *
	 * @param $pid
	 * @author Djenad Razic
	 */
	public function closeProcess($pid)
	{
		// Create process spawner and set the PID
		$process = new ProcessSpawner();
		$process->setPid($pid);

		// Stop the process
		$process->stop();

		$this->redis_client->hdel("process", $pid);
	}
}