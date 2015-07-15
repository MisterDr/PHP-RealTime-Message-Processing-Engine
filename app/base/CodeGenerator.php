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
	 * @var string
	 */
	protected $className;

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

	/**
	 * @param $name string cClass name
	 * @param array $comment array
	 */
	public function __construct($name = NULL, $comment = array())
	{
		$this->config = new Config();
		$this->viewPath = $this->config->getBasePath() . '/app/views/';

		$this->engine = new Engine($this->viewPath);

		if ($name !== NULL)
		{
			$this->className = $name;
			$this->addClass($name, $comment);
		}
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
		$this->structure['classes'][$name]['implementations'] = array();
		$this->structure['classes'][$name]['extends'] = "";
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
	public function addMethod($name, $types, $parameters = array(), $body = array(), $comment = array(), $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

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
	public function addConstant($name, $value, $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

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
	public function addProperty($name, $value, $type, $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

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
	public function addNamespace($name, $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

		$this->structure['classes'][$class]['namespace'] = $name;
	}

	/**
	 * Add class references
	 *
	 * @param $class
	 * @param $name
	 * @author Djenad Razic
	 */
	public function addReference($name, $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

		$this->structure['classes'][$class]['references'][] = $name;
	}

	/**
	 * Add implementation
	 *
	 * @param $class
	 * @param $name
	 * @author Djenad Razic
	 */
	public function addImplementation($name, $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

		$this->structure['classes'][$class]['implementations'][] = $name;
	}

	/**
	 * Add class inheritance
	 *
	 * @param $class
	 * @param $name
	 * @author Djenad Razic
	 */
	public function addExtends($name, $class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

		$this->structure['classes'][$class]['extends'][] = $name;
	}

	/**
	 * Generate class output
	 *
	 * @param $class
	 * @author Djenad Razic
	 * @return string
	 */
	public function generate($class = NULL)
	{
		$class = $class === NULL ? $this->className : $class;

		$data = array(
			'root' => $this->structure['classes'][$class],
			'className' => $class
		);

		return $this->engine->render('code/class', $data);
	}
}

// Objects