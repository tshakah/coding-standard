<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

class UseOnlyWhitelistedNamespacesSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testUseOnlyWhitelistedNamespaces()
	{
		$report = self::checkFile(
			__DIR__ . '/data/whitelistedNamespacesInUses.php',
			['namespacesRequiredToUse' => [
				'Foo',
			]]
		);

		self::assertSniffError(
			$report,
			5,
			UseOnlyWhitelistedNamespacesSniff::CODE_NON_FULLY_QUALIFIED,
			'Dolor'
		);
		self::assertNoSniffError($report, 6);
		self::assertSniffError(
			$report,
			7,
			UseOnlyWhitelistedNamespacesSniff::CODE_NON_FULLY_QUALIFIED,
			'Fooo\Baz'
		);
		self::assertSniffError(
			$report,
			8,
			UseOnlyWhitelistedNamespacesSniff::CODE_NON_FULLY_QUALIFIED,
			'Lorem\Ipsum'
		);
	}

	public function testIgnoreUseFromAnonymousFunction()
	{
		$report = self::checkFile(
			__DIR__ . '/data/whitelistedNamespacesInUses.php'
		);
		self::assertNoSniffError($report, 12);
	}

	public function testIgnoreTraitUses()
	{
		$report = self::checkFile(
			__DIR__ . '/data/whitelistedNamespacesInUses.php'
		);
		self::assertNoSniffError($report, 19);
		self::assertNoSniffError($report, 20);
		self::assertNoSniffError($report, 21);
	}

	public function testAllowUseFromRootNamespace()
	{
		$report = self::checkFile(
			__DIR__ . '/data/whitelistedNamespacesInUses.php',
			[
				'namespacesRequiredToUse' => [
					'Foo',
				],
				'allowUseFromRootNamespace' => true,
			]
		);

		self::assertNoSniffError($report, 5);
		self::assertNoSniffError($report, 6);
		self::assertSniffError(
			$report,
			7,
			UseOnlyWhitelistedNamespacesSniff::CODE_NON_FULLY_QUALIFIED,
			'Fooo\Baz'
		);
		self::assertSniffError(
			$report,
			8,
			UseOnlyWhitelistedNamespacesSniff::CODE_NON_FULLY_QUALIFIED,
			'Lorem\Ipsum'
		);
	}

}
