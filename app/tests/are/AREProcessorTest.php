<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests\are;

use app\are\AREContext;
use app\are\AREProcessor;

class AREProcessorTest extends \PHPUnit_Framework_TestCase {


	public function testProcessor()
	{
		$processor = new AREProcessor();

		$processor->process("create new class");
		$processor->process("create new class with name MotorHead");

		$processor->process("create new class with name MotorHead which has following properties: Test1, Test2, Prole.");


		$processor->process("create new class using name MotorHead");

		$processor->process("insert bottle in the asshole");


		$processor->process("I wish to create new class");

		$processor->process("Wll this is awkward. I really wish to create some new class if I may to ask.");

	}

	/**
	 * Test Stanford NLP processing engine
	 *
	 * @author Djenad Razic
	 */
	public function testStanfordParser()
	{
//		$context = new AREContext();
//
//		$context->parse("What does the fox say?");
//		//$context->nerTag("The Federal Reserve Bank of New York led by Timothy R. Geithner.");
//		$context->posTag("What does the fox say?");
	}
}
