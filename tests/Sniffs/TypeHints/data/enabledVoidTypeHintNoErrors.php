<?php

function func()
{
	return;
}

abstract class VoidClass
{

	public function __construct()
	{

	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.UselessDocComment
	 * @return void
	 */
	public function __destruct()
	{

	}

	public function __clone()
	{

	}

	abstract public function abstractMethod();

	public function method()
	{
		return;
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint
	 */
	public function withSuppress()
	{
		return;
	}

}

function () {

};

function () {
	return;
};

function () {
	function (): bool {
		return true;
	};
	new class {
		public function foo(): bool
		{
			return true;
		}
	};
};

function () {
	return true;
};

function (): bool {
	return true;
};
