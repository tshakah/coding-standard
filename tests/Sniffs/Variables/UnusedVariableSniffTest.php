<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Variables;

use SlevomatCodingStandard\Sniffs\TestCase;

class UnusedVariableSniffTest extends TestCase
{

	public function testNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/unusedVariableNoErrors.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/unusedVariableErrors.php');

		self::assertSame(19, $report->getErrorCount());

		self::assertSniffError($report, 7, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $firstMatch.');
		self::assertSniffError($report, 12, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $unused.');
		self::assertSniffError($report, 18, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $value.');
		self::assertSniffError($report, 23, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $key.');
		self::assertSniffError($report, 23, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $value.');
		self::assertSniffError($report, 28, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $a.');
		self::assertSniffError($report, 28, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $b.');
		self::assertSniffError($report, 32, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $c.');
		self::assertSniffError($report, 32, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $d.');
		self::assertSniffError($report, 36, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $i.');
		self::assertSniffError($report, 42, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $current.');
		self::assertSniffError($report, 49, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $current.');
		self::assertSniffError($report, 54, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $count.');
		self::assertSniffError($report, 58, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $c.');
		self::assertSniffError($report, 62, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $a.');
		self::assertSniffError($report, 70, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $a.');
		self::assertSniffError($report, 78, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $unused.');
		self::assertSniffError($report, 83, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $a.');
		self::assertSniffError($report, 88, UnusedVariableSniff::CODE_UNUSED_VARIABLE, 'Unused variable $a.');
	}

}
