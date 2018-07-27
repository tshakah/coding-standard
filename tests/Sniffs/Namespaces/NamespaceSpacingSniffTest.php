<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

class NamespaceSpacingSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoNamespaceNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingNoNamespace.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testNamespaceWithCurlyBraces()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingNamespaceWithCurlyBraces.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testDefaultSettingsNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingWithDefaultSettingsNoErrors.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testDefaultSettingsErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingWithDefaultSettingsErrors.php');

		self::assertSame(2, $report->getErrorCount());

		self::assertSniffError($report, 2, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_BEFORE_NAMESPACE);
		self::assertSniffError($report, 2, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_AFTER_NAMESPACE);

		self::assertAllFixedInFile($report);
	}

	public function testAfterOpenTagNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingAfterOpenTagNoErrors.php');
		self::assertNoSniffErrorInFile($report);
	}

	public function testAfterOpenTagErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingAfterOpenTagErrors.php');

		self::assertSame(1, $report->getErrorCount());

		self::assertSniffError($report, 2, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_BEFORE_NAMESPACE);

		self::assertAllFixedInFile($report);
	}

	public function testModifiedSettingsNoErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingWithModifiedSettingsNoErrors.php', [
			'linesCountBeforeNamespace' => 0,
			'linesCountAfterNamespace' => 2,
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testModifiedSettingsErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingWithModifiedSettingsErrors.php', [
			'linesCountBeforeNamespace' => 0,
			'linesCountAfterNamespace' => 2,
		]);

		self::assertSame(2, $report->getErrorCount());

		self::assertSniffError($report, 4, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_BEFORE_NAMESPACE);
		self::assertSniffError($report, 4, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_AFTER_NAMESPACE);

		self::assertAllFixedInFile($report);
	}

	public function testNoLineBeforeNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingNoLineBeforeNamespace.php');

		self::assertSame(1, $report->getErrorCount());

		self::assertSniffError($report, 3, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_BEFORE_NAMESPACE);
	}

	public function testNoLineAfterNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingNoLineAfterNamespace.php');

		self::assertSame(1, $report->getErrorCount());

		self::assertSniffError($report, 3, NamespaceSpacingSniff::CODE_INCORRECT_LINES_COUNT_AFTER_NAMESPACE);
	}

	public function testNoCodeAfterNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/namespaceSpacingNoCodeAfterNamespace.php');
		self::assertNoSniffErrorInFile($report);
	}

}
