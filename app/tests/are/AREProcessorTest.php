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
		return;
		$context = new AREContext();

		$context->parse("What does the fox say?");
		//$context->nerTag("The Federal Reserve Bank of New York led by Timothy R. Geithner.");
		$context->posTag("What does the fox say?");
	}
}
