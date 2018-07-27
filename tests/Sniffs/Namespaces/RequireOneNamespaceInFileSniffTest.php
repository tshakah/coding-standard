<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use SlevomatCodingStandard\Sniffs\TestCase;

class RequireOneNamespaceInFileSniffTest extends TestCase
{

	public function testNoErrors()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/requireOneNamespaceInFileNoErrors.php'));
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/requireOneNamespaceInFileErrors.php');

		self::assertSame(2, $report->getErrorCount());

		self::assertSniffError($report, 8, RequireOneNamespaceInFileSniff::CODE_MORE_NAMESPACES_IN_FILE);
		self::assertSniffError($report, 13, RequireOneNamespaceInFileSniff::CODE_MORE_NAMESPACES_IN_FILE);
	}

	public function testNoNamespaceNoError()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/requireOneNamespaceInFileNoNamespaceNoErrors.php'));
	}

}
