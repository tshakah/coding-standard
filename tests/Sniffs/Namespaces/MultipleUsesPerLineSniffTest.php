<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

class MultipleUsesPerLineSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	private function getFileReport(): \PHP_CodeSniffer\Files\File
	{
		return self::checkFile(__DIR__ . '/data/multipleUsesPerLine.php');
	}

	public function testMultipleUsesPerLine()
	{
		self::assertSniffError(
			$this->getFileReport(),
			5,
			MultipleUsesPerLineSniff::CODE_MULTIPLE_USES_PER_LINE
		);
	}

	public function testIgnoreCommasInClosureUse()
	{
		self::assertNoSniffError($this->getFileReport(), 7);
	}

}
