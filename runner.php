<?php
/**
 * Class and method runner for task automation
 *
 * @author: Djenad Razic
 */

use app\base\Config;
use app\base\Migrator;

$header = array(
	'',
	'****************************************',
	'* Task Runner for Asynchronio engine   *',
	'****************************************',
	''
);

const NO_TASK = 'No task supplied to runner!';

// Installed tasks / shortcuts
$tasks = array(
	'db:setup'      => 'Initialize database for migration.',
	'db:migrate'    => 'Migrate unprocessed schemas (db:migrate {up} / {down}).',
	'db:downgrade'  => 'Undo last migration',
	'db:create'     => 'Create new migration (db:create {table} {field=type} {field=type} ..)'
);


if (file_exists("vendor/autoload.php"))
{
	include "vendor/autoload.php";
}
else if (file_exists("../vendor/autoload.php"))
{
	include "../vendor/autoload.php";
}
else
{
	include "../../vendor/autoload.php";
}

// Display welcome
logMsg($header, 'dark_grey');

// Get class parameter and throw exception if not available
$task_name = $argv[1];

// Check if task is supplied
noVar($task_name, NO_TASK, $tasks);

// Get config
$config = new Config();

$task_parts = explode(':', $task_name);
$params = array_slice($argv, 2, count($argv));

switch ($task_parts[0])
{
	case 'db':

		// Get our migrator
		$migrator = new Migrator();

		switch ($task_parts[1])
		{
			case 'setup':
				break;
			case 'migrate':
				if ( ! isset($params[0]) OR strtolower($params[0]) == 'up')
				{
					$migrator->migrate(Migrator::UP);
				}
				else
				{
					$migrator->migrate(Migrator::DOWN);
				}
				break;
			case 'downgrade':
				break;
			case 'create':

				if ( ! isset($params[0]))
				{
					noVar($params[0], 'Must include table name.');
				}

				// Get table name and parameters
				$table_name = array_shift($params);
				$fields = array();

				// Check for valid data type and display notice
				$data_types = array_keys(Migrator::$data_types);

				foreach ($params as $param)
				{
					$field = explode('=', $param);
					$fields[$field[0]] = strtoupper($field[1]);

					if ( ! in_array($fields[$field[0]], $data_types))
					{
						logMsg("Invalid parameter for field: $field[0]", 'red');
						logMsg(array_merge(
							array("Valid parameters are:", ''),
							$data_types), 'blue');
						exit;
					}
				}

				// Crate migration
				$migrator->create($table_name, $fields);

				break;
		}
		break;
}

/**
 * Check for var
 *
 * @param $var
 * @param $msg
 * @param $tasks
 * @param string $type
 * @author Djenad Razic
 */
function noVar($var, $msg, $tasks = array(), $type = 'tasks')
{
	if ( ! isset($var) OR (! in_array($var, array_keys($tasks)) AND count($tasks) > 0))
	{
		logMsg($msg, 'red');

		if (count($tasks) > 0)
		{
			logMsg("List of $type available to run:", 'blue');
			logMsg("");
		}

		foreach ($tasks as $key => $value)
		{
			logMsg("$key\t = $value", 'blue');
		}

		logMsg("\r\n");

		exit;
	}
}

/**
 * Log message to the console
 *
 * @param $msg
 * @param $font_color
 * @author Djenad Razic
 */
function logMsg($msg, $font_color = NULL)
{
	if ( ! is_array($msg))
	{
		$msg = $font_color === NULL ? $msg : Colors::getColoredString($msg, $font_color);
		echo $msg . "\r\n";
	}
	else
	{
		foreach ($msg as $part)
		{
			$part = $font_color === NULL ? $part : Colors::getColoredString($part, $font_color);
			echo $part . "\r\n";
		}
	}
}

/**
 * Simple CLI Colours Class
 */
class Colors {

	private static $foreground_colors = array(
		'black' => '0;30',
		'dark_gray' => '1;30',
		'blue' => '0;34',
		'light_blue' => '1;34',
		'green' => '0;32',
		'light_green' => '1;32',
		'cyan' => '0;36',
		'light_cyan' => '1;36',
		'red' => '0;31',
		'light_red' => '1;31',
		'purple' => '0;35',
		'light_purple' => '1;35',
		'brown' => '0;33',
		'yellow' => '1;33',
		'light_gray' => '0;37',
		'white' => '1;37'
	);
	private static $background_colors = array();

	public function __construct() {

		self::$background_colors['black'] = '40';
		self::$background_colors['red'] = '41';
		self::$background_colors['green'] = '42';
		self::$background_colors['yellow'] = '43';
		self::$background_colors['blue'] = '44';
		self::$background_colors['magenta'] = '45';
		self::$background_colors['cyan'] = '46';
		self::$background_colors['light_gray'] = '47';
	}

	// Returns colored string
	public static function getColoredString($string, $foreground_color = null, $background_color = null) {
		$colored_string = "";

		// Check if given foreground color found
		if (isset(self::$foreground_colors[$foreground_color])) {
			$colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . "m";
		}
		// Check if given background color found
		if (isset(self::$background_colors[$background_color])) {
			$colored_string .= "\033[" . self::$background_colors[$background_color] . "m";
		}

		// Add string and end coloring
		$colored_string .=  $string . "\033[0m";

		return $colored_string;
	}

	// Returns all foreground color names
	public static function getForegroundColors() {
		return array_keys(self::$foreground_colors);
	}

	// Returns all background color names
	public static function getBackgroundColors() {
		return array_keys(self::$background_colors);
	}
}