<?php
/**
 * @author: Djenad Razic
 */

namespace app;


use Memio\Memio\Config\Build;
use Memio\Model\Argument;
use Memio\Model\Constant;
use Memio\Model\Contract;
use Memio\Model\File;
use Memio\Model\Method;
use Memio\Model\Object;
use Memio\Model\Phpdoc\ApiTag;
use Memio\Model\Phpdoc\DeprecationTag;
use Memio\Model\Phpdoc\Description;
use Memio\Model\Phpdoc\LicensePhpdoc;
use Memio\Model\Phpdoc\StructurePhpdoc;
use Memio\Model\Property;
use Memio\PrettyPrinter\PrettyPrinter;


class CodeGenerator {

	const METHOD_ABSTRACT = 1;
	const METHOD_FINAL = 2;
	const METHOD_PRIVATE = 3;
	const METHOD_PROTECTED = 4;
	const METHOD_PUBLIC = 5;
	const METHOD_STATIC = 6;

	/**
	 * @var PrettyPrinter
	 */
	protected $prettyPrinter;

	public function __construct()
	{
		$this->prettyPrinter = Build::prettyPrinter();
	}

	/**
	 * Generate doc block
	 *
	 * @param $doc
	 * @param null $apiTag
	 * @author Djenad Razic
	 * @return StructurePhpdoc
	 */
	public function generateClassComment($doc, $apiTag = NULL)
	{
		// Parse and crate description
		$comments = explode('\n', $doc);
		$description = Description::make($comments[0]);

		// Remove first element
		unset($comments[0]);

		foreach ($comments as $comment)
		{
			if (empty($comment))
			{
				$description->addEmptyLine();
			}
			else
			{
				$description->addLine($comment);
			}
		}

		$docBloc = StructurePhpdoc::make()->setDescription($description);

		if ($apiTag !== NULL)
		{
			$docBloc->setApiTag(new ApiTag($apiTag));
		}

		return $docBloc;
	}

	/**
	 * Generate class object
	 *
	 * @param $name string
	 * @param $constants mixed
	 * @param $properties mixed
	 * @author Djenad Razic
	 * @return Object
	 */
	public function generateObject($name, $constants, $properties)
	{
		$object = new Object($name);

		foreach ($constants as $key => $value)
		{
			$object->addConstant(new Constant($key, $value));
		}

		foreach ($properties as $property)
		{
			$object->addProperty(new Property($property));
		}

		return $object;
	}

	/**
	 * Create method
	 *
	 * @param $name string
	 * @param $arguments array
	 * @param $types array
	 * @param $body string
	 * @author Djenad Razic
	 * @return Method
	 */
	public function generateMethod($name, $arguments, $types, $body)
	{
		$method = new Method($name);

		foreach ($types as $type)
		{
			switch ($type)
			{
				case self::METHOD_ABSTRACT:
					$method->makeAbstract();
					break;

				case self::METHOD_FINAL:
					$method->makeFinal();
					break;

				case self::METHOD_PRIVATE:
					$method->makePrivate();
					break;

				case self::METHOD_PUBLIC:
					$method->makePublic();
					break;

				case self::METHOD_PROTECTED:
					$method->makeProtected();
					break;

				case self::METHOD_STATIC:
					$method->makeAbstract();
					break;
			}
		}

		foreach ($arguments as $type => $name)
		{
			$method->addArgument(new Argument($type, $name));
		}

		$method->setBody($body);

		return $method;
	}

	/**
	 * Generate class structure
	 *
	 * @param $path
	 * @param Object|Object $object
	 * @param LicensePhpdoc | null $licenseDoc
	 * @return File
	 * @author Djenad Razic
	 */
	public function generateClass($path, Object $object, $licenseDoc = NULL)
	{
		$file = File::make($path)->setStructure($object);

		if ($licenseDoc !== NULL)
		{
			$file->setLicensePhpdoc($licenseDoc);
		}

		return $file;
	}
}