<?php
/**
 * @author: Djenad Razic
 */

namespace app\base;


class Validation {

	/**
	 * @var array
	 */
	protected $fields;

	public function __construct($fields = NULL)
	{
		if ($fields !== NULL)
		{
			$this->fields = $fields;
		}
	}

	/**
	 * Validate post fields
	 *
	 * @author Djenad Razic
	 */
	public function validate()
	{
		// Validate
		foreach ($this->fields as $field)
		{
			if ( ! isset($_POST[$field]))
				throw new \InvalidArgumentException("Field: $field must be set.");
		}

		// Filter var
		foreach ($_POST as $key => $value)
		{
			$_POST[$key] = filter_var($_POST[$key], FILTER_SANITIZE_STRING);
		}
	}
}