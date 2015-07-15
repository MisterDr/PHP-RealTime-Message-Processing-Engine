<?php
/**
 * @author: Djenad Razic
 */

namespace app\base;


interface MigratorInterface
{
	public function up();
	public function down();
}