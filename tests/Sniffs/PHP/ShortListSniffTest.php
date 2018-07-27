<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\PHP;

use SlevomatCodingStandard\Sniffs\TestCase;

class ShortListSniffTest extends TestCase
{

	public function testNoErrors()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/shortListNoErrors.php'));
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/shortListErrors.php');

		self::assertSame(14, $report->getErrorCount());

		self::assertSniffError($report, 3, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 4, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 5, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 6, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 9, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 11, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 13, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 17, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 18, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 19, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 23, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 25, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 27, ShortListSniff::CODE_LONG_LIST_USED);
		self::assertSniffError($report, 29, ShortListSniff::CODE_LONG_LIST_USED);

		self::assertAllFixedInFile($report);
	}

}
