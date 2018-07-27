<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Sniffs\TestCase;

class FullyQualifiedClassNameAfterKeywordSniffUseTest extends TestCase
{

	protected static function getSniffClassName(): string
	{
		return FullyQualifiedClassNameAfterKeywordSniff::class;
	}

	private function getFileReport(): File
	{
		return self::checkFile(
			__DIR__ . '/data/fullyQualifiedUse.php',
			['keywordsToCheck' => ['T_USE']]
		);
	}

	public function testIgnoreUseInClosure()
	{
		self::assertNoSniffError($this->getFileReport(), 34);
	}

	public function testIgnoreUseInNamespace()
	{
		self::assertNoSniffError($this->getFileReport(), 5);
	}

	public function testIgnoreUseInNamespaceWithParenthesis()
	{
		self::assertNoSniffErrorInFile(self::checkFile(
			__DIR__ . '/data/fullyQualifiedUseNamespaceWithParenthesis.php',
			['keywordsToCheck' => ['T_USE']]
		));
	}

	public function testNonFullyQualifiedUse()
	{
		self::assertSniffError(
			$this->getFileReport(),
			14,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('use'),
			'Dolor in use'
		);
	}

	public function testFullyQualifiedUse()
	{
		self::assertNoSniffError($this->getFileReport(), 9);
	}

	public function testMultipleFullyQualifiedUse()
	{
		self::assertNoSniffError($this->getFileReport(), 19);
	}

	public function testMultipleUseWithFirstWrong()
	{
		self::assertSniffError(
			$this->getFileReport(),
			24,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('use'),
			'Dolor in use'
		);
	}

	public function testMultipleUseWithSecondAndThirdWrong()
	{
		$report = $this->getFileReport();
		self::assertSniffError(
			$report,
			29,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('use'),
			'Amet in use'
		);
		self::assertSniffError(
			$report,
			29,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('use'),
			'Omega in use'
		);
	}

}
