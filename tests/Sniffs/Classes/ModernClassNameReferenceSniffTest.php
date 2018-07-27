<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Classes;

use SlevomatCodingStandard\Sniffs\TestCase;

class ModernClassNameReferenceSniffTest extends TestCase
{

	public function testNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/modernClassNameReferenceNoErrors.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/modernClassNameReferenceErrors.php');

		self::assertSame(5, $report->getErrorCount());

		self::assertSniffError($report, 12, ModernClassNameReferenceSniff::CODE_CLASS_NAME_REFERENCED_VIA_MAGIC_CONSTANT);
		self::assertSniffError($report, 17, ModernClassNameReferenceSniff::CODE_CLASS_NAME_REFERENCED_VIA_FUNCTION_CALL);
		self::assertSniffError($report, 22, ModernClassNameReferenceSniff::CODE_CLASS_NAME_REFERENCED_VIA_FUNCTION_CALL);
		self::assertSniffError($report, 27, ModernClassNameReferenceSniff::CODE_CLASS_NAME_REFERENCED_VIA_FUNCTION_CALL);
		self::assertSniffError($report, 32, ModernClassNameReferenceSniff::CODE_CLASS_NAME_REFERENCED_VIA_FUNCTION_CALL);

		self::assertAllFixedInFile($report);
	}

}
