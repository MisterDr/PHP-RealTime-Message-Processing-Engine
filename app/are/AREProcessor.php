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

		// At this point we have whole sentence parsed. Let's process with words which we need.
		foreach ($this->content['typedDependencies'] as $dep)
		{
			// TODO: Parse all words and all types
			switch ($dep['type'])
			{
				case self::TYPED_DEPENDENCY_ROOT:
					break;
				case self::TYPED_DEPENDENCY_AMOD:
					break;
				case self::TYPED_DEPENDENCY_DOBJ:
					$this->parseDobj($dep);
					break;
			}
		}
	}

	/**
	 * Parse related object
	 *
	 * @author Djenad Razic
	 */
	protected function parseDobj($object)
	{
		foreach ($object as $info)
		{
			if (is_array($info))
			{

			}
		}
	}

	protected function parseStructural()
	{

	}
}