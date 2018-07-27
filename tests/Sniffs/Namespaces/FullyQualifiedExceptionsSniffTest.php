<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Sniffs\TestCase;
use Throwable;
use TypeError;

class FullyQualifiedExceptionsSniffTest extends TestCase
{

	private function getFileReport(): File
	{
		return self::checkFile(__DIR__ . '/data/fullyQualifiedExceptionNames.php');
	}

	public function testNonFullyQualifiedExceptionInTypeHint()
	{
		self::assertSniffError(
			$this->getFileReport(),
			3,
			FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION,
			'FooException'
		);
	}

	public function testNonFullyQualifiedExceptionInThrow()
	{
		self::assertSniffError(
			$this->getFileReport(),
			6,
			FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION,
			'FooException'
		);
	}

	public function testNonFullyQualifiedExceptionInCatch()
	{
		self::assertSniffError(
			$this->getFileReport(),
			7,
			FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION,
			'BarException'
		);
		self::assertSniffError(
			$this->getFileReport(),
			9,
			FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION,
			Throwable::class
		);
		self::assertSniffError(
			$this->getFileReport(),
			11,
			FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION,
			TypeError::class
		);
	}

	public function testFullyQualifiedExceptionInTypeHint()
	{
		self::assertNoSniffError($this->getFileReport(), 16);
	}

	public function testFullyQualifiedExceptionInThrow()
	{
		self::assertNoSniffError($this->getFileReport(), 19);
	}

	public function testFullyQualifiedExceptionInCatch()
	{
		self::assertNoSniffError($this->getFileReport(), 20);
		self::assertNoSniffError($this->getFileReport(), 22);
		self::assertNoSniffError($this->getFileReport(), 24);
		self::assertNoSniffError($this->getFileReport(), 26);
		self::assertNoSniffError($this->getFileReport(), 28);
	}

	public function testClassSuffixedErrorOrExceptionIsNotAnExceptionButReported()
	{
		$report = self::checkFile(__DIR__ . '/data/ignoredNames.php');
		self::assertSniffError($report, 3, FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION);
		self::assertSniffError($report, 7, FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION);
	}

	public function testIgnoredNames()
	{
		$report = self::checkFile(__DIR__ . '/data/ignoredNames.php', [
			'ignoredNames' => [
				'LibXMLError',
				'LibXMLException',
			],
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testClassSuffixedErrorOrExceptionIsNotAnExceptionButReportedInNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/ignoredNamesInNamespace.php');
		self::assertNoSniffError($report, 5); // *Error names are reported only with a root namespace
		self::assertSniffError($report, 9, FullyQualifiedExceptionsSniff::CODE_NON_FULLY_QUALIFIED_EXCEPTION);
		self::assertNoSniffError($report, 13); // look like Exception but isn't - handled by ReferenceUsedNamesOnlySniff
		self::assertNoSniffError($report, 17); // dtto
	}

	public function testIgnoredNamesInNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/ignoredNamesInNamespace.php', [
			'ignoredNames' => [
				'IgnoredNames\\LibXMLException',
			],
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testFixableFullyQualified()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableFullyQualifiedExceptions.php');
		self::assertAllFixedInFile($report);
	}

}
