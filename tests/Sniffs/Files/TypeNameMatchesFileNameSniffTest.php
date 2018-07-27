<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Files;

class TypeNameMatchesFileNameSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testError()
	{
		$report = self::checkFile(__DIR__ . '/data/rootNamespace/boo.php', [
			'rootNamespaces' => ['tests/Sniffs/Files/data/rootNamespace' => 'RootNamespace'],
			'ignoredNamespaces' => ['IgnoredNamespace'],
		]);

		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 5, TypeNameMatchesFileNameSniff::CODE_NO_MATCH_BETWEEN_TYPE_NAME_AND_FILE_NAME);

		$report = self::checkFile(__DIR__ . '/data/rootNamespace/coo/Foo.php', [
			'rootNamespaces' => ['tests/Sniffs/Files/data/rootNamespace' => 'RootNamespace'],
			'ignoredNamespaces' => ['IgnoredNamespace'],
		]);

		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 5, TypeNameMatchesFileNameSniff::CODE_NO_MATCH_BETWEEN_TYPE_NAME_AND_FILE_NAME);
	}

	public function testNoError()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/rootNamespace/Foo.php', [
			'rootNamespaces' => ['tests/Sniffs/Files/data/rootNamespace' => 'RootNamespace'],
			'ignoredNamespaces' => ['IgnoredNamespace'],
		]));
	}

	public function testSkippedDir()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/rootNamespace/skippedDir/Bar.php', [
			'rootNamespaces' => ['tests/Sniffs/Files/data/rootNamespace' => 'RootNamespace'],
			'ignoredNamespaces' => ['IgnoredNamespace'],
			'skipDirs' => ['skippedDir'],
		]));
	}

	public function testIgnoredNamespace()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/ignoredNamespace.php', [
			'ignoredNamespaces' => ['IgnoredNamespace'],
		]));
	}

	public function testNoNamespace()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/noNamespace.php'));
	}

	public function testRootNamespacesNormalization()
	{
		$sniffProperties1 = [
			'rootNamespaces' => [
				'tests/Sniffs/Files/data/rootNamespace2/Xxx' => 'RootNamespace2',
				'tests/Sniffs/Files/data/rootNamespace2' => 'RootNamespace2',
				'tests/Sniffs/Files/data/rootNamespace' => 'RootNamespace',
			],
		];
		$sniffProperties2 = [
			'rootNamespaces' => [
				'tests/Sniffs/Files/data/rootNamespace' => 'RootNamespace',
				'tests/Sniffs/Files/data/rootNamespace2' => 'RootNamespace2',
				'tests/Sniffs/Files/data/rootNamespace2/Xxx' => 'RootNamespace2',
			],
		];

		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/rootNamespace2/Foo.php', $sniffProperties1));
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/rootNamespace2/Xxx/Boo.php', $sniffProperties1));

		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/rootNamespace2/Foo.php', $sniffProperties2));
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/rootNamespace2/Xxx/Boo.php', $sniffProperties2));
	}

}
