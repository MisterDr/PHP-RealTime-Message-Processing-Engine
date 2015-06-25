<?php
/**
 * Simple process creator from class name
 *
 * @author: Djenad Razic
 */

namespace app\common;

use InvalidArgumentException;

class ProcessSpawner {

	/**
	 * @var int Process ID
	 */
	private $pid;

	/**
	 * @var string Command to execute
	 */
	private $command;

	/**
	 * @var string Process path to pick up
	 */
	private $process_path = 'app/common/';

	/**
	 * @var string Class name to spawn
	 */
	private $class_name;

	public function __construct($process_path = NULL, $class_name = NULL)
	{
		// Run class as command
		if (isset($class_name) && isset($process_path))
		{

			//TODO: Fix
			//$path = $_SERVER['DOCUMENT_ROOT'] . "../" . $this->process_path;

			$path = '/Volumes/mrdr/develop/MessageProcessor/' . $this->process_path;
			//$path = $this->process_path;

			$this->command = "php $path" . "ProcessRunner.php app\\\\services\\\\$class_name";
			$this->class_name = $class_name;
		}
	}

	/**
	 * Create process prom designated class
	 * The class should have init function to call after instantiating
	 * This uses 'nohup' to spawn the process
	 *
	 * @author Djenad Razic
	 */
	private function runCommand()
	{
		$command = 'nohup ' . $this->command . ' > /dev/null 2>&1 & echo $!';
		exec($command, $output);
		$this->pid = (int)$output[0];

		return $this->pid;
	}

	/**
	 * Set process ID
	 *
	 * @param $pid
	 * @author Djenad Razic
	 */
	public function setPid($pid)
	{
		$this->pid = $pid;
	}

	/**
	 * Get process ID
	 *
	 * @author Djenad Razic
	 * @return int
	 */
	public function getPid()
	{
		return $this->pid;
	}

	/**
	 * Get process status with ps
	 *
	 * @author Djenad Razic
	 * @return bool
	 */
	public function status()
	{
		$command = 'ps -p ' . $this->pid;
		exec($command, $output);
		if ( ! isset($output[1]))
			return FALSE;

		return TRUE;
	}

	/**
	 * Run the process
	 *
	 * @author Djenad Razic
	 * @return bool|int
	 */
	public function start()
	{
		if ($this->command != '')
			return $this->runCommand();

		return TRUE;
	}

	/**
	 * Kill process with specific process id
	 *
	 * @author Djenad Razic
	 * @return bool
	 */
	public function stop()
	{
		$command = 'kill ' . $this->pid;
		exec($command);
		if ($this->status() == FALSE)
			return TRUE;

		return FALSE;
	}

	/**
	 * Create instance of this (No singleton only lazy instancing)
	 *
	 * @author Djenad Razic
	 */
	public function instance()
	{
		return new $this;
	}
}