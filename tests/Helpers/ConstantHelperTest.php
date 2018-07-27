<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Helpers;

class ConstantHelperTest extends \SlevomatCodingStandard\Helpers\TestCase
{

	public function testNameWithNamespace()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/constantWithNamespace.php');

		$constantPointer = $this->findConstantPointerByName($codeSnifferFile, 'FOO');
		self::assertSame('\FooNamespace\FOO', ConstantHelper::getFullyQualifiedName($codeSnifferFile, $constantPointer));
		self::assertSame('FOO', ConstantHelper::getName($codeSnifferFile, $constantPointer));
	}

	public function testNameWithoutNamespace()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/constantWithoutNamespace.php');

		$constantPointer = $this->findConstantPointerByName($codeSnifferFile, 'FOO');
		self::assertSame('FOO', ConstantHelper::getFullyQualifiedName($codeSnifferFile, $constantPointer));
		self::assertSame('FOO', ConstantHelper::getName($codeSnifferFile, $constantPointer));
	}

	public function testGetAllNames()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/constantNames.php');
		self::assertSame(['FOO', 'BOO'], ConstantHelper::getAllNames($codeSnifferFile));
	}

	public function testGetAllNamesNoNamespace()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/constantWithoutNamespace.php');
		self::assertSame(['FOO'], ConstantHelper::getAllNames($codeSnifferFile));
	}

}
