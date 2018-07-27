<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Classes;

class ClassConstantVisibilitySniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/classWithConstants.php', [
			'enabled' => true,
		]);

		self::assertSame(1, $report->getErrorCount());

		self::assertNoSniffError($report, 7);
		self::assertNoSniffError($report, 9);
		self::assertNoSniffError($report, 10);

		self::assertSniffError(
			$report,
			6,
			ClassConstantVisibilitySniff::CODE_MISSING_CONSTANT_VISIBILITY,
			'Constant \ClassWithConstants::PUBLIC_FOO visibility missing.'
		);
	}

	public function testNoClassConstants()
	{
		$report = self::checkFile(__DIR__ . '/data/noClassConstants.php', [
			'enabled' => true,
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testNoClassConstantsWithNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/noClassConstantsWithNamespace.php', [
			'enabled' => true,
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testDisabledSniff()
	{
		$report = self::checkFile(__DIR__ . '/data/classWithConstants.php', [
			'enabled' => false,
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testFixableEnabled()
	{
		$report = self::checkFile(
			__DIR__ . '/data/fixableMissingClassConstantVisibility.php',
			['fixable' => true],
			[ClassConstantVisibilitySniff::CODE_MISSING_CONSTANT_VISIBILITY]
		);
		self::assertAllFixedInFile($report);
	}

	public function testFixableDisabled()
	{
		$report = self::checkFile(
			__DIR__ . '/data/fixableMissingClassConstantVisibilityFixableDisabled.php',
			['fixable' => false],
			[ClassConstantVisibilitySniff::CODE_MISSING_CONSTANT_VISIBILITY]
		);
		self::assertAllFixedInFile($report);
	}

}
