<?php
/**
 * Small process runner script to run the processes from configuration file
 *
 * @author: Djenad Razic
 */

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

// Get class parameter and throw exception if not available
$class_name = $argv[1];

if ( ! isset($class_name))
	throw new InvalidArgumentException('No class supplied to runner!');

// Run the class
$class_name = new $class_name;