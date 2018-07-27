<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Helpers;

use PHP_CodeSniffer\Files\File;
use const T_DOC_COMMENT_OPEN_TAG;
use function array_map;

class DocCommentHelperTest extends TestCase
{

	/** @var \PHP_CodeSniffer\Files\File */
	private $testedCodeSnifferFile;

	public function testClassHasDocComment()
	{
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithDocCommentAndDescription')));
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithDocComment')));
	}

	public function testClassGetDocComment()
	{
		self::assertSame("* Class WithDocComment\n *\n * @see https://www.slevomat.cz", DocCommentHelper::getDocComment($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithDocCommentAndDescription')));
		self::assertNull(DocCommentHelper::getDocComment($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithoutDocComment')));
	}

	public function testClassHasNoDocComment()
	{
		self::assertFalse(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithoutDocComment')));
	}

	public function testClassHasEmptyDocComment()
	{
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'EmptyDocComment')));
		self::assertNull(DocCommentHelper::getDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'EmptyDocComment')));
	}

	public function testClassHasDocCommentDescription()
	{
		self::assertTrue(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithDocCommentAndDescription')));
	}

	public function testClassHasNoDocCommentDescription()
	{
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithDocComment')));
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'WithoutDocComment')));
	}

	public function testConstantHasDocComment()
	{
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITH_DOC_COMMENT_AND_DESCRIPTION')));
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITH_DOC_COMMENT')));
	}

	public function testConstantHasNoDocComment()
	{
		self::assertFalse(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITHOUT_DOC_COMMENT')));
	}

	public function testConstantHasDocCommentDescription()
	{
		self::assertTrue(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITH_DOC_COMMENT_AND_DESCRIPTION')));
	}

	public function testConstantHasNoDocCommentDescription()
	{
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITH_DOC_COMMENT')));
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITHOUT_DOC_COMMENT')));
	}

	public function testPropertyHasDocComment()
	{
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withDocCommentAndDescription')));
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withDocComment')));
	}

	public function testPropertyHasNoDocComment()
	{
		self::assertFalse(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withoutDocComment')));
	}

	public function testPropertyHasDocCommentDescription()
	{
		self::assertTrue(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withDocCommentAndDescription')));
	}

	public function testPropertyHasNoDocCommentDescription()
	{
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withDocComment')));
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withoutDocComment')));
	}

	public function testPropertyInLegacyFormatHasDocComment()
	{
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'legacyWithDocComment')));
	}

	public function testFunctionHasDocComment()
	{
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withDocCommentAndDescription')));
		self::assertTrue(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withDocComment')));
	}

	public function testFunctionHasNoDocComment()
	{
		self::assertFalse(DocCommentHelper::hasDocComment($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withoutDocComment')));
	}

	public function testFunctionHasDocCommentDescription()
	{
		self::assertTrue(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withDocCommentAndDescription')));
	}

	public function testFunctionHasNoDocCommentDescription()
	{
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withDocComment')));
		self::assertFalse(DocCommentHelper::hasDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withoutDocComment')));
	}

	public function testConstantGetDocCommentDescription()
	{
		self::assertEquals(
			['Constant WITH_DOC_COMMENT_AND_DESCRIPTION'],
			$this->stringifyComments(DocCommentHelper::getDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'WITH_DOC_COMMENT_AND_DESCRIPTION')))
		);
	}

	public function testPropertyGetDocCommentDescription()
	{
		self::assertSame(
			['Property with doc comment and description'],
			$this->stringifyComments(DocCommentHelper::getDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'withDocCommentAndDescription')))
		);
	}

	public function testFunctionGetDocCommentDescription()
	{
		self::assertSame(
			['Function with doc comment and description', 'And is multi-line'],
			$this->stringifyComments(DocCommentHelper::getDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), 'withDocCommentAndDescription')))
		);
	}

	public function testUnboundGetDocCommentDescription()
	{
		self::assertSame(
			['Created by Slevomat.'],
			$this->stringifyComments(DocCommentHelper::getDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findPointerByLineAndType($this->getTestedCodeSnifferFile(), 3, T_DOC_COMMENT_OPEN_TAG)))
		);
	}

	public function testUnboundMultiLineGetDocCommentDescription()
	{
		self::assertSame(
			['This is', 'multiline.'],
			$this->stringifyComments(DocCommentHelper::getDocCommentDescription($this->getTestedCodeSnifferFile(), $this->findPointerByLineAndType($this->getTestedCodeSnifferFile(), 5, T_DOC_COMMENT_OPEN_TAG)))
		);
	}

	public function testIsInline()
	{
		$codeSnifferFile = $this->getTestedCodeSnifferFile();

		foreach ([3, 10, 18, 32, 46, 51, 76, 99] as $line) {
			self::assertFalse(DocCommentHelper::isInline($codeSnifferFile, $this->findPointerByLineAndType($codeSnifferFile, $line, T_DOC_COMMENT_OPEN_TAG)));
		}

		foreach ([96] as $line) {
			self::assertTrue(DocCommentHelper::isInline($codeSnifferFile, $this->findPointerByLineAndType($codeSnifferFile, $line, T_DOC_COMMENT_OPEN_TAG)));
		}
	}

	private function getTestedCodeSnifferFile(): File
	{
		if ($this->testedCodeSnifferFile === null) {
			$this->testedCodeSnifferFile = $this->getCodeSnifferFile(
				__DIR__ . '/data/docComment.php'
			);
		}
		return $this->testedCodeSnifferFile;
	}

	/**
	 * @param \SlevomatCodingStandard\Helpers\Comment[] $comments
	 * @return string[]
	 */
	private function stringifyComments(array $comments): array
	{
		return array_map(function (Comment $comment): string {
			return $comment->getContent();
		}, $comments);
	}

}
