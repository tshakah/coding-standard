<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\ControlStructures;

class DisallowEqualOperatorsSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoErrors()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/disallowEqualOperatorsNoErrors.php'));
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/disallowEqualOperatorsErrors.php');

		self::assertSame(4, $report->getErrorCount());

		self::assertSniffError($report, 3, DisallowEqualOperatorsSniff::CODE_DISALLOWED_EQUAL_OPERATOR);
		self::assertSniffError($report, 4, DisallowEqualOperatorsSniff::CODE_DISALLOWED_EQUAL_OPERATOR);
		self::assertSniffError($report, 5, DisallowEqualOperatorsSniff::CODE_DISALLOWED_NOT_EQUAL_OPERATOR);
		self::assertSniffError($report, 6, DisallowEqualOperatorsSniff::CODE_DISALLOWED_NOT_EQUAL_OPERATOR);

		$this->assertAllFixedInFile($report);
	}

}
