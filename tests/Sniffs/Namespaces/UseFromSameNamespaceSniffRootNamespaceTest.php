<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use SlevomatCodingStandard\Sniffs\TestCase;

class UseFromSameNamespaceSniffRootNamespaceTest extends TestCase
{

	protected static function getSniffClassName(): string
	{
		return UseFromSameNamespaceSniff::class;
	}

	public function testUseFromRootNamespaceInFileWithoutNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/useFromRootNamespaceWithoutNamespace.php');
		self::assertSniffError(
			$report,
			3,
			UseFromSameNamespaceSniff::CODE_USE_FROM_SAME_NAMESPACE,
			'Foo'
		);
		self::assertNoSniffError($report, 4);
	}

}
