<?php
/**
 * Very simple code generator
 *
 * @author: Djenad Razic
 */

namespace app\base;

use League\Plates\Engine;

class CodeGenerator {

	const METHOD_ABSTRACT   = 1;
	const METHOD_FINAL      = 2;
	const METHOD_PRIVATE    = 3;
	const METHOD_PROTECTED  = 4;
	const METHOD_PUBLIC     = 5;
	const METHOD_STATIC     = 6;

	const PROP_PRIVATE      = 1;
	const PROP_PUBLIC       = 2;
	const PROP_PROTECTED    = 3;
	const PROP_STATIC       = 4;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * View path
	 *
	 * @var string
	 */
	protected $viewPath;

	/**
	 * View engine
	 *
	 * @var Engine
	 */
	protected $engine;

	/**
	 * Code structure
	 *
	 * @var array
	 */
	private $structure = array(
		'classes' => array()
	);

	public function __construct()
	{
		$this->config = new Config();
		$this->viewPath = $this->config->getBasePath() . '/app/views/';

		$this->engine = new Engine($this->viewPath);
	}

	/**
	 * Generate Class with specific name
	 *
	 * @param $name
	 * @param $comment array
	 * @author Djenad Razic
	 */
	public function addClass($name, $comment)
	{
		$this->structure['classes'][$name] = array();
		$this->structure['classes'][$name]['methods'] = array();
		$this->structure['classes'][$name]['constants'] = array();
		$this->structure['classes'][$name]['properties'] = array();
		$this->structure['classes'][$name]['references'] = array();
		$this->structure['classes'][$name]['namespace'] = "";
		$this->structure['classes'][$name]['comment'] = $comment;
	}

	/**
	 * Add method
	 *
	 * @param $class      string
	 * @param $name       string
	 * @param $types      array
	 * @param $parameters array
	 * @param $body       array
	 * @param $comment    array
	 * @author Djenad Razic
	 */
	public function addMethod($class, $name, $types, $parameters, $body, $comment)
	{
		$methodTypes = array();

		foreach ($types as $type)
		{
			switch ($type)
			{
				case self::METHOD_ABSTRACT:
					$methodTypes[] = "abstract";
					break;

				case self::METHOD_FINAL:
					$methodTypes[] = "final";
					break;

				case self::METHOD_PRIVATE:
					$methodTypes[] = "private";
					break;

				case self::METHOD_PUBLIC:
					$methodTypes[] = "public";
					break;

				case self::METHOD_PROTECTED:
					$methodTypes[] = "protected";
					break;

				case self::METHOD_STATIC:
					$methodTypes[] = "static";
					break;
			}
		}

		$this->structure['classes'][$class]['methods'][$name] = array(
			'body'          => $body,
			'parameters'    => $parameters,
			'types'         => $methodTypes,
			'comment'       => $comment
		);
	}

	/**
	 * Add constant
	 *
	 * @param $class    string
	 * @param $name     string
	 * @param $value    mixed
	 * @author Djenad Razic
	 */
	public function addConstant($class, $name, $value)
	{
		$this->structure['classes'][$class]['constants'][$name] = $value;
	}

	/**
	 * Add property
	 *
	 * @param $class
	 * @param $name
	 * @param $value
	 * @param $type
	 * @author Djenad Razic
	 */
	public function addProperty($class, $name, $value, $type)
	{
		$typeValue = "private";

		switch ($type)
		{
			case self::PROP_PRIVATE:
				$typeValue = "private";
				break;
			case self::PROP_PUBLIC:
				$typeValue = "public";
				break;
			case self::PROP_PROTECTED:
				$typeValue = "protected";
				break;
			case self::PROP_STATIC:
				$typeValue = "static";
				break;
		}

		$this->structure['classes'][$class]['properties'][$name] = array(
			'type'  => $typeValue,
			'value' => $value
		);
	}

	/**
	 * Add class namespace
	 *
	 * @param $class
	 * @param $name
	 * @author Djenad Razic
	 */
	public function addNamespace($class, $name)
	{
		$this->structure['classes'][$class]['namespace'] = $name;
	}

	/**
	 * Add class references
	 *
	 * @param $class
	 * @param $name
	 * @author Djenad Razic
	 */
	public function addReference($class, $name)
	{
		$this->structure['classes'][$class]['references'][] = $name;
	}

	/**
	 * Generate class output
	 *
	 * @param $class
	 * @author Djenad Razic
	 * @return string
	 */
	public function generate($class)
	{
		$data = array(
			'root' => $this->structure['classes'][$class],
			'className' => $class
		);

		return $this->engine->render('code/class', $data);
	}
}

// Objects