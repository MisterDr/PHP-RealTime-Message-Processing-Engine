<?php
/**
 * Simple migrator to handle database
 *
 * @author: Djenad Razic
 */

namespace app\base;


use app\CodeGenerator;
use R;

class Migrator {

	// Migration direction
	const UP    = 1;
	const DOWN  = 2;

	/**
	 * Create simple migration class
	 *
	 * @param null $name
	 * @param array $fields
	 * @author Djenad Razic
	 * @return string
	 */
	public function create($name = NULL, $fields = array())
	{
		// Create filename
		$fileName = time() . "_$name.php";

		// Crate class according to the parameters
		$codeGenerator = new CodeGenerator();

		$code = $codeGenerator->generateClass($name, [],
			[
				$codeGenerator->generateProperty('config')
			],
			[
				// Create constructor
				$codeGenerator->generateMethod('__construct',
					[],
					[CodeGenerator::METHOD_PUBLIC],
					[
						'$this->config = new Config();',
						"R::setup( \"mysql:host=\$this->config->mysql['host'];dbname=\$this->config->mysql['dbname']', \$this->config->mysql['login']', \$this->config->mysql['password']\" );"
					],
					['Constructor']),

				// Create UP method
				$codeGenerator->generateMethod('up',
					[],
					[CodeGenerator::METHOD_PUBLIC, CodeGenerator::METHOD_STATIC],
					["echo \$test;"],
					['Migrate UP']),

				// Create DOWN method
				$codeGenerator->generateMethod('down',
					[],
					[CodeGenerator::METHOD_PUBLIC, CodeGenerator::METHOD_STATIC],
					["echo \$test;"],
					['Migrate DOWN'])

			]);

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

	}
}