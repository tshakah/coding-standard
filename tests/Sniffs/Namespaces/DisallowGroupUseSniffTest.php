<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

class DisallowGroupUseSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoErrors()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/disallowGroupUseNoErrors.php'));
	}

	public function testErrors()
	{
		$codeSnifferFile = self::checkFile(__DIR__ . '/data/disallowGroupUseErrors.php');

		self::assertSniffError($codeSnifferFile, 5, DisallowGroupUseSniff::CODE_DISALLOWED_GROUP_USE);
		self::assertSniffError($codeSnifferFile, 9, DisallowGroupUseSniff::CODE_DISALLOWED_GROUP_USE);
	}

}
