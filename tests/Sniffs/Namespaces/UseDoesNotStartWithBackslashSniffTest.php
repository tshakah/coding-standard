<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

class UseDoesNotStartWithBackslashSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/useDoesNotStartWithBackslashNoErrors.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/useDoesNotStartWithBackslashErrors.php');

		self::assertSame(3, $report->getErrorCount());

		self::assertSniffError($report, 3, UseDoesNotStartWithBackslashSniff::CODE_STARTS_WITH_BACKSLASH);
		self::assertSniffError($report, 4, UseDoesNotStartWithBackslashSniff::CODE_STARTS_WITH_BACKSLASH);
		self::assertSniffError($report, 5, UseDoesNotStartWithBackslashSniff::CODE_STARTS_WITH_BACKSLASH);
	}

	public function testFixable()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableUseDoesNotStartWithBackslash.php', [], [UseDoesNotStartWithBackslashSniff::CODE_STARTS_WITH_BACKSLASH]);
		self::assertAllFixedInFile($report);
	}

}
