<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests\generators\code;


use app\base\CodeGenerator;

class CodeGeneratorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test code generator
	 *
	 * @author Djenad Razic
	 */
	public function testClass()
	{
		$codeGenerator = new CodeGenerator();

		$codeGenerator->addClass('Meho', array('CopyLeft', '@author Djenad Razic'));
		$codeGenerator->addProperty('Meho', 'alo', 1, CodeGenerator::PROP_PROTECTED);
		$codeGenerator->addProperty('Meho', 'alo2', 1, CodeGenerator::PROP_PROTECTED);

		$codeGenerator->addReference('Meho', 'app\base\CodeGenerator3');
		$codeGenerator->addNamespace('Meho', 'app\base');

		$codeGenerator->addConstant('Meho', 'test', '1');

		$codeGenerator->addMethod(
			'Meho',
			'test',
			array(
				CodeGenerator::METHOD_PUBLIC,
				CodeGenerator::METHOD_STATIC
			),
			array('array' => 'input'),
			array('echo 1;'),
			array('Test method', '', '@author Djenad Razic')
			);

		// Thou shall be generated
		$code = $codeGenerator->generate('Meho');

		$this->assertNotEmpty($code, 'Not generated');
	}
}
