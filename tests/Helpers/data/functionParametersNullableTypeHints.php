<?php

namespace FooNamespace;

abstract class FooClass
{

	public function allParametersWithNullableTypeHints($string, int $int = 10, $bool, float $float = 0.0, ?callable $callable, ?array $array, ?\FooNamespace\FooClass $object = null)
	{

	}

	abstract public function someParametersWithNullableTypeHints($string, int $int, ?bool $bool = true, float $float, ?callable $callable, array $array = [], ?\FooNamespace\FooClass $object);

	abstract public function parametersWithWeirdDefinition($string,int$int,?bool$bool=true,float$float,?callable$callable,array$array=[],?\FooNamespace\FooClass$object);

}
