<?php

use Mockery as m;
use Robbo\SchemaBuilder\Builder;

class SchemaBuilderTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}


	public function testHasTableCorrectlyCallsGrammar()
	{
		$connection = m::mock('Robbo\SchemaBuilder\Connection');
		$grammar = m::mock('StdClass');
		$connection->shouldReceive('getSchemaGrammar')->andReturn($grammar);
		$builder = new Builder($connection);
		$grammar->shouldReceive('compileTableExists')->once()->andReturn('sql');
		$connection->shouldReceive('getTablePrefix')->once()->andReturn('prefix_');
		$connection->shouldReceive('select')->once()->with('sql', array('prefix_table'))->andReturn(array('prefix_table'));

		$this->assertTrue($builder->hasTable('table'));
	}

}