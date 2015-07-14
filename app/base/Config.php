<?php
/**
 * @author: Djenad Razic
 */

namespace app\base;

class Config
{
	// Installation files
	const POS_URL = 'http://nlp.stanford.edu/downloads/stanford-postagger-2015-04-20.zip';
	const POS_SAVE_PATH = 'app/are/external/pos/stanford-postagger-2015-04-20.zip';
	const POS_PATH = 'app/are/external/pos/stanford-postagger-2015-04-20/';

	const NER_URL = 'http://nlp.stanford.edu/software/stanford-ner-2015-04-20.zip';
	const NER_SAVE_PATH = 'app/are/external/ner/stanford-ner-2015-04-20.zip';
	const NER_PATH = 'app/are/external/ner/stanford-ner-2015-04-20/';

	const PARSER_URL = 'http://nlp.stanford.edu/software/stanford-parser-full-2015-04-20.zip';
	const PARSER_SAVE_PATH = 'app/are/external/parser/stanford-parser-full-2015-04-20.zip';
	const PARSER_PATH = 'app/are/external/parser/stanford-parser-full-2015-04-20/';

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

	// MySql credentials
	public $mysql = array(
		'host'      => 'localhost',
		'dbname'    => 'test',
		'login'     => 'root',
		'password'  => 'zglongara'
	);

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