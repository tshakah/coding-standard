<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use SlevomatCodingStandard\Sniffs\TestCase;

class AlphabeticallySortedUsesSniffTest extends TestCase
{

	public function testIncorrectOrder()
	{
		self::assertSniffError(
			self::checkFile(__DIR__ . '/data/incorrectOrder.php'),
			5,
			AlphabeticallySortedUsesSniff::CODE_INCORRECT_ORDER,
			'Second\FooObject'
		);
	}

	public function testIncorrectOrderIntertwinedWithClasses()
	{
		self::assertSniffError(
			self::checkFile(__DIR__ . '/data/incorrectOrderIntertwinedWithClasses.php'),
			18,
			AlphabeticallySortedUsesSniff::CODE_INCORRECT_ORDER,
			'Delta'
		);
	}

	public function testCorrectOrderIgnoresUsesAfterClassesTraitsAndInterfaces()
	{
		self::assertNoSniffErrorInFile(
			self::checkFile(__DIR__ . '/data/correctOrder.php')
		);
	}

	public function testCorrectOrderOfSimilarNamespaces()
	{
		self::assertNoSniffErrorInFile(
			self::checkFile(__DIR__ . '/data/correctOrderSimilarNamespaces.php')
		);
	}

	public function testCorrectOrderOfSimilarNamespacesCaseSensitive()
	{
		self::assertNoSniffErrorInFile(
			self::checkFile(__DIR__ . '/data/correctOrderSimilarNamespacesCaseSensitive.php', [
				'caseSensitive' => true,
			])
		);
	}

	public function testIncorrectOrderOfSimilarNamespaces()
	{
		self::assertSniffError(
			self::checkFile(__DIR__ . '/data/incorrectOrderSimilarNamespaces.php'),
			6,
			AlphabeticallySortedUsesSniff::CODE_INCORRECT_ORDER,
			'Foo\Bar'
		);
	}

	public function testPatrikOrder()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/alphabeticalPatrik.php'));
	}

	public function testFixable()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableAlphabeticalSortedUses.php', [], [AlphabeticallySortedUsesSniff::CODE_INCORRECT_ORDER]);
		self::assertAllFixedInFile($report);
	}

	public function testFixablePsr12Compatible()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableAlphabeticalSortedUsesPsr12Compatible.php', [
			'psr12Compatible' => true,
		], [AlphabeticallySortedUsesSniff::CODE_INCORRECT_ORDER]);
		self::assertAllFixedInFile($report);
	}

}
