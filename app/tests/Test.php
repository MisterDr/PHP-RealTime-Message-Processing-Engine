<?php
/**
 * @author: Djenad Razic
 */

namespace app\tests;

use app\base\Config;
use app\base\Routes;
use RedBeanPHP\R;
use League\Plates\Engine;

class Test extends \PHPUnit_Framework_TestCase {

	public function testLoadView()
	{
		$config = new Config();
		$path = $config->getBasePath() . '/app/views/upload/';

		$templates = new Engine($path);
		$template = $templates->render('login');

		//$routes = new Routes();
		//$result = $routes->process(['test', 'testView']);

	}

//	public function testCreate()
//	{
//		R::setup( 'mysql:host=localhost;dbname=test', 'root', 'zglongara' );
//
//		$book = R::dispense( 'book' );
//
//	    $book->title = 'Learn to Program';
//	    $book->rating = 10;
//
//	    $book['price'] = 29.99; //you can use array notation as well
//
//	    $id = R::store( $book );
//	}
}
