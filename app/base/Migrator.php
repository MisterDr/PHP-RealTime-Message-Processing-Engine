<?php
/**
 * Simple migrator to handle database
 *
 * @author: Djenad Razic
 */

namespace app\base;

use RedBeanPHP\QueryWriter\MySQL;
use RedBeanPHP\R;

class Migrator implements MigratorInterface {

	// Migration direction
	const UP    = 1;
	const DOWN  = 2;

	// Data types
	public static $data_types = array(
	 'BOOL'       => 0,
	 'UINT32'     => 2,
	 'DOUBLE'     => 3,
	 'TEXT7'      => 4,
	 'TEXT8'      => 5,
	 'TEXT16'     => 6,
	 'TEXT32'     => 7,
	 'DATE'       => 80,
	 'DATETIME'   => 81,
	 'POINT'      => 90,
	 'LINESTRING' => 91,
	 'POLYGON'    => 92
	);

	/**
	 * @var string
	 */
	protected $migration_path;

	/**
	 * @var Config
	 */
	protected $config = NULL;

	public function __construct()
	{
		$this->config = new Config();

		$this->migration_path = $this->config->getBasePath() . "/app/migrations/";

		// Configure our simple autoloader to load specific migrations
		Config::register();

		// Setup database from configuration if not already
		if (count(R::$toolboxes) == 0)
		{
			R::setup("mysql:host={$this->config->mysql['host']};dbname={$this->config->mysql['dbname']}",
				$this->config->mysql['login'], $this->config->mysql['password']);
		}
	}

	/**
	 * Create simple migration class
	 *
	 * @param null $name
	 * @param array $fields
	 * @param bool $writeFile
	 * @return string
	 * @author Djenad Razic
	 */
	public function create($name = NULL, $fields = array(), $writeFile = TRUE)
	{
		// Create filename
		$fileName = time() . "_$name.php";

		// Crate class according to the parameters
		$codeGenerator = new CodeGenerator($name, array("$name Migration", '', '@author {insert_me}'));

		// Add migration namespace
		$codeGenerator->addNamespace('app\\migrations');

		// Add references
		$codeGenerator->addReference('app\\base\\Migrator');
		$codeGenerator->addReference('app\\base\\MigratorInterface');
		$codeGenerator->addReference('RedBeanPHP\R;');

		// Add interface implementation
		$codeGenerator->addImplementation('MigratorInterface');

		// Extends base class
		$codeGenerator->addExtends('Migrator');

		// Create UP method
		$codeGenerator->addMethod('up',
			array(CodeGenerator::METHOD_PUBLIC),
			array(),
			$this->addFields($name, $fields),
			array('Migrate UP'));

		// Create DOWN method
		$codeGenerator->addMethod('down',
			array(CodeGenerator::METHOD_PUBLIC),
			array(),
			$this->deleteTable($name),
			array('Migrate DOWN'));


		// Generate code and write it at migrations folder
		$code = $codeGenerator->generate();

		// Write file at the migrations folder
		if ($writeFile)
		{
			// And write file
			$path = $this->config->getBasePath() . "/app/migrations/" . $fileName;
			file_put_contents($path, $code);
		}

		return $code;
	}

	/**
	 * Add fields
	 *
	 * @param $table  string
	 * @param $fields array
	 * @author Djenad Razic
	 * @return array
	 */
	public function addFields($table, array $fields)
	{
		$code = array(
			'$writer = R::getWriter();',
			"\$writer->createTable('$table');"
		);

		// Add columns
		foreach ($fields as $key => $value)
		{
			$value = self::$data_types[$value];
			$code[] = "\$writer->addColumn('$table', '$key', $value);";
		}

		// Call post
		$code[] = "parent::up();";

		return $code;
	}

	/**
	 * Delete table
	 *
	 * @param $table
	 * @author Djenad Razic
	 * @return array
	 */
	protected function deleteTable($table)
	{
		$code = array(
			"R::exec('DROP TABLE IF EXISTS $table;');",
			// Call post
			"parent::down();"
		);

		return $code;
	}

	/**
	 * Migrate up or down
	 *
	 * @param $direction
	 * @author Djenad Razic
	 */
	public function migrate($direction)
	{
		if ($direction == self::UP)
		{
			// Get files
			$files = scandir($this->migration_path);
			$files = array_slice($files, 2, count($files));

			if (in_array('migrations', R::inspect()))
			{
				// Get migrated records
				$migrated_files = R::getCol('SELECT name FROM migrations');
			}
			else
			{
				$migrated_files = array();
			}

			// Get non migrated files
			$non_migrated = array_diff($files, $migrated_files);

			// Load non migrated files and execute
			foreach ($non_migrated as $file)
			{
				$instance = $this->loadMigration($file);
				$instance->up();

				// Record our migration
				$this->storeMigration($file);
			}
		}
		else
		{
			$migration = R::findOne('migrations', ' ORDER BY created DESC ');

			// Load migration and migrate it down
			$instance = $this->loadMigration($migration->name);
			$instance->down();

			// Remove migration form database
			R::trash($migration);
		}
	}

	/**
	 * Store migration
	 *
	 * @param $fileName
	 * @author Djenad Razic
	 * @throws \RedBeanPHP\RedException
	 */
	protected function storeMigration($fileName)
	{
		// Store migration at the database
		$migration = R::dispense('migrations');
		$migration->name = $fileName;
		$migration->created = microtime(TRUE);
		R::store($migration);
	}

	/**
	 * Lod migration file
	 *
	 * @param $fileName
	 * @author Djenad Razic
	 * @return MigratorInterface
	 */
	protected function loadMigration($fileName)
	{
		// Get our class name
		$file_parts = explode('_', $fileName);
		$class_name = 'app\migrations\\'.pathinfo(implode('_', array_slice($file_parts, 1, count($file_parts))), PATHINFO_FILENAME);

		// Register file and namespace for autoloader
		Config::$autoload_files[$class_name] = $this->migration_path.$fileName;

		return new $class_name();
	}

	/**
	 * Virtual method
	 *
	 * @author Djenad Razic
	 */
	public function up()
	{
		//TODO: Add post hooks if any
	}

	/**
	 * Virtual method
	 *
	 * @author Djenad Razic
	 */
	public function down()
	{
		//TODO: Add post hooks if any
	}
}