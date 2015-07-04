<?php
/**
 * @author: Djenad Razic
 *
 * Probably the basic word to start with :D
 */

namespace app\are\mind;

use app\are\AREContext;
use app\are\IAREMindSet;

class Create implements IAREMindSet {

	/**
	 * @var AREContext
	 */
	protected $context;

	public function __construct(AREContext $context)
	{

	}


	public function process(array $parameters)
	{
		// TODO: Implement process() method.
	}
}