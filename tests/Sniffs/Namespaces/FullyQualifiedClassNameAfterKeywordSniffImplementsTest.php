<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Sniffs\TestCase;

class FullyQualifiedClassNameAfterKeywordSniffImplementsTest extends TestCase
{

	protected static function getSniffClassName(): string
	{
		return FullyQualifiedClassNameAfterKeywordSniff::class;
	}

	private function getFileReport(): File
	{
		return self::checkFile(
			__DIR__ . '/data/fullyQualifiedImplements.php',
			['keywordsToCheck' => ['T_IMPLEMENTS']]
		);
	}

	public function testNonFullyQualifiedImplements()
	{
		self::assertSniffError(
			$this->getFileReport(),
			8,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('implements'),
			'Dolor in implements'
		);
	}

	public function testFullyQualifiedImplements()
	{
		self::assertNoSniffError($this->getFileReport(), 3);
	}

	public function testMultipleFullyQualifiedImplements()
	{
		self::assertNoSniffError($this->getFileReport(), 13);
	}

	public function testMultipleImplementsWithFirstWrong()
	{
		self::assertSniffError(
			$this->getFileReport(),
			18,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('implements'),
			'Dolor in implements'
		);
	}

	public function testMultipleImplementsWithSecondAndThirdWrong()
	{
		$report = $this->getFileReport();
		self::assertSniffError(
			$report,
			23,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('implements'),
			'Amet in implements'
		);
		self::assertSniffError(
			$report,
			23,
			FullyQualifiedClassNameAfterKeywordSniff::getErrorCode('implements'),
			'Omega in implements'
		);
	}

}
