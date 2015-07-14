<?php
/**
 * @author: Djenad Razic
 */

namespace app\base\helpers;


class StringHelper {

	/**
	 * Implode KVP
	 *
	 * @param array $array
	 * @param string $prefix
	 * @param string $separator
	 * @param string $delimiter
	 * @return string
	 * @author Djenad Razic
	 */
	public static function implodeKvp(array $array, $prefix = '', $separator = ',', $delimiter = ' ')
	{
		$out = $sep = '';
		foreach( $array as $key => $value ) {
			$out .= $sep . $key . $delimiter . $prefix . $value;
			$sep = $separator;
		}

		return $out;
	}
}