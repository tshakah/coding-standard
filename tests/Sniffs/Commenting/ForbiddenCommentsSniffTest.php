<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Commenting;

class ForbiddenCommentsSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testThrowExceptionForInvalidPattern()
	{
		$this->expectException(\Throwable::class);

		self::checkFile(
			__DIR__ . '/data/noForbiddenComments.php',
			['forbiddenCommentPatterns' => ['invalidPattern']]
		);
	}

	public function testNoForbiddenComments()
	{
		$report = self::checkFile(__DIR__ . '/data/noForbiddenComments.php', [
			'forbiddenCommentPatterns' => ['~Foo\d+~', '~Not comment\.~'],
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testForbiddenComments()
	{
		$report = self::checkFile(__DIR__ . '/data/forbiddenComments.php', [
			'forbiddenCommentPatterns' => ['~Created by PhpStorm\.~', '~(\S+\s+)?Constructor\.~', '~(blah){3}~'],
		], [ForbiddenCommentsSniff::CODE_COMMENT_FORBIDDEN]);

		self::assertSame(4, $report->getErrorCount());

		self::assertSniffError($report, 4, ForbiddenCommentsSniff::CODE_COMMENT_FORBIDDEN);
		self::assertSniffError($report, 10, ForbiddenCommentsSniff::CODE_COMMENT_FORBIDDEN);
		self::assertSniffError($report, 36, ForbiddenCommentsSniff::CODE_COMMENT_FORBIDDEN);
		self::assertSniffError($report, 48, ForbiddenCommentsSniff::CODE_COMMENT_FORBIDDEN);

		self::assertAllFixedInFile($report);
	}

}
