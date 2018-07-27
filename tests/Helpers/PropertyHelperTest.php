<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Helpers;

class PropertyHelperTest extends \SlevomatCodingStandard\Helpers\TestCase
{

	/** @var \PHP_CodeSniffer\Files\File */
	private $testedCodeSnifferFile;

	/**
	 * @return mixed[][]
	 */
	public function dataIsProperty(): array
	{
		return [
			[
				'$boolean',
				true,
			],
			[
				'$string',
				true,
			],
			[
				'$boo',
				false,
			],
			[
				'$hoo',
				false,
			],
			[
				'$weirdDefinition',
				true,
			],
		];
	}

	/**
	 * @dataProvider dataIsProperty
	 * @param string $variableName
	 * @param bool $isProperty
	 */
	public function testIsProperty(string $variableName, bool $isProperty)
	{
		$codeSnifferFile = $this->getTestedCodeSnifferFile();

		$variablePointer = TokenHelper::findNextContent($codeSnifferFile, T_VARIABLE, $variableName, 0);
		self::assertSame($isProperty, PropertyHelper::isProperty($codeSnifferFile, $variablePointer));
	}

	public function testNameWithNamespace()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/propertyWithNamespace.php');
		self::assertSame('\FooNamespace\FooClass::$fooProperty', PropertyHelper::getFullyQualifiedName($codeSnifferFile, $this->findPropertyPointerByName($codeSnifferFile, 'fooProperty')));
	}

	public function testNameWithoutsNamespace()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/propertyWithoutNamespace.php');
		self::assertSame('\FooClass::$fooProperty', PropertyHelper::getFullyQualifiedName($codeSnifferFile, $this->findPropertyPointerByName($codeSnifferFile, 'fooProperty')));
	}

	public function testNameInAnonymousClass()
	{
		$codeSnifferFile = $this->getCodeSnifferFile(__DIR__ . '/data/propertyInAnonymousClass.php');
		self::assertSame('class@anonymous::$fooProperty', PropertyHelper::getFullyQualifiedName($codeSnifferFile, $this->findPropertyPointerByName($codeSnifferFile, 'fooProperty')));
	}

	private function getTestedCodeSnifferFile(): \PHP_CodeSniffer\Files\File
	{
		if ($this->testedCodeSnifferFile === null) {
			$this->testedCodeSnifferFile = $this->getCodeSnifferFile(
				__DIR__ . '/data/propertyOrNot.php'
			);
		}
		return $this->testedCodeSnifferFile;
	}

}
