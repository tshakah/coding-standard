<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use SlevomatCodingStandard\Sniffs\TestCase;

class FullyQualifiedGlobalFunctionsSniffTest extends TestCase
{

	public function testNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/fullyQualifiedGlobalFunctionsNoErrors.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/fullyQualifiedGlobalFunctionsErrors.php');

		self::assertSame(2, $report->getErrorCount());

		self::assertSniffError($report, 17, FullyQualifiedGlobalFunctionsSniff::CODE_NON_FULLY_QUALIFIED, 'Function min() should be referenced via a fully qualified name.');
		self::assertSniffError($report, 31, FullyQualifiedGlobalFunctionsSniff::CODE_NON_FULLY_QUALIFIED, 'Function MaX() should be referenced via a fully qualified name.');

		self::assertAllFixedInFile($report);
	}

	public function testExcludeErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/fullyQualifiedGlobalFunctionsExcludeErrors.php', [
			'exclude' => ['min'],
		]);

		self::assertSame(1, $report->getErrorCount());

		self::assertSniffError($report, 28, FullyQualifiedGlobalFunctionsSniff::CODE_NON_FULLY_QUALIFIED, 'Function max() should be referenced via a fully qualified name.');

		self::assertAllFixedInFile($report);
	}

}
