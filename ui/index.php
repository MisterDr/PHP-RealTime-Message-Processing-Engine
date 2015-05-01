<?php
/**
 * Setup small url processing router and process the incoming requests
 *
 * @author: Djenad Razic
 */

use app\base\Routes;


include "../vendor/autoload.php";

// Setup the small router
$router = new Routes();