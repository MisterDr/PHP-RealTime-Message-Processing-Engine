<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests;


use app\CodeGenerator;

class CodeGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testClassGenerator()
	{
		$codeGenerator = new CodeGenerator();

		// One liner
		$code = $codeGenerator->generateClass('Meho', [
			'CONST1' => 'testConst'
		],
		[
			$codeGenerator->generateProperty('alo', CodeGenerator::PROP_PUBLIC),
			$codeGenerator->generateProperty('alo2', CodeGenerator::PROP_PUBLIC),
		],
		[
			$codeGenerator->generateMethod('udri',
				['string' => 'test'],
				[CodeGenerator::METHOD_PUBLIC, CodeGenerator::METHOD_STATIC],
				"\t\techo \$test;",
				['Hello', '', 'Everybody'])
		]);


		// Structured
		$constants = array('CONST1' => 'testConst');

		$props = array(
			$codeGenerator->generateProperty('alo', CodeGenerator::PROP_PUBLIC),
			$codeGenerator->generateProperty('alo2', CodeGenerator::PROP_PUBLIC)
		);

		$methods = array(
			$codeGenerator->generateMethod(

				// Method name
				'udri',

				// Method arguments
				['string' => 'test'],

				// Add multiple visibility
				[CodeGenerator::METHOD_PUBLIC, CodeGenerator::METHOD_STATIC],

				// Add code
				"\t\techo \$test;",

				// Add comment
				['Hello', '', 'Everybody'])
		);

		$sameCode = $codeGenerator->generateClass('Meho', $constants, $props, $methods);

		$this->assertEquals($code, $sameCode);
	}
}
