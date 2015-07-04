<?php
/**
 * Asynchronio Reasoning Engine word processor
 *
 * @author: Djenad Razic
 */

namespace app\are;


class AREProcessor extends AREContext {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Process given sentence
	 *
	 * @param $sentence
	 * @author Djenad Razic
	 */
	public function process($sentence)
	{
		$this->parse($sentence);

	}
}