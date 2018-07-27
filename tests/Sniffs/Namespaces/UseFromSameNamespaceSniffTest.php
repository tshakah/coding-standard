<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Sniffs\TestCase;

class UseFromSameNamespaceSniffTest extends TestCase
{

	private function getFileReport(): File
	{
		return self::checkFile(__DIR__ . '/data/useFromSameNamespace.php');
	}

	public function testUnrelatedNamespaces()
	{
		$report = $this->getFileReport();
		self::assertNoSniffError($report, 5);
		self::assertNoSniffError($report, 6);
		self::assertNoSniffError($report, 10);
	}

	public function testUseWithAsPart()
	{
		self::assertNoSniffError($this->getFileReport(), 7);
	}

	public function testUseFromSubnamespace()
	{
		self::assertNoSniffError($this->getFileReport(), 9);
	}

	public function testUseFromSameNamespace()
	{
		self::assertSniffError(
			$this->getFileReport(),
			8,
			UseFromSameNamespaceSniff::CODE_USE_FROM_SAME_NAMESPACE,
			'Lorem\Ipsum\Dolor'
		);
	}

	public function testSkipClosure()
	{
		self::assertNoSniffError($this->getFileReport(), 12);
	}

	public function testCheckNearestPreviousNamespaceWithMultipleNamespacesInFile()
	{
		$report = $this->getFileReport();
		self::assertSniffError(
			$report,
			18,
			UseFromSameNamespaceSniff::CODE_USE_FROM_SAME_NAMESPACE,
			'Bar\Baz\Test'
		);
		self::assertNoSniffError($report, 19);
	}

	public function testFixableUseFromSameNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableUseFromSameNamespace.php', [], [UseFromSameNamespaceSniff::CODE_USE_FROM_SAME_NAMESPACE]);
		self::assertAllFixedInFile($report);
	}

}
