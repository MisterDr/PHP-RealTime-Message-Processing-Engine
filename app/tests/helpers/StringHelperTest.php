<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests\helpers;


use app\base\helpers\StringHelper;

class StringHelperTest extends \PHPUnit_Framework_TestCase {

	public function testString()
	{
		$array = array('test1' => 'test2', 'test3' => 'test4');

		$result = StringHelper::implodeKvp($array);
	}
}
