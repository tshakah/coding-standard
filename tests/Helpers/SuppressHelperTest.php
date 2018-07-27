<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Helpers;

class SuppressHelperTest extends \SlevomatCodingStandard\Helpers\TestCase
{

	private const CHECK_NAME = 'Sniff.Sniff.Sniff.check';

	/** @var \PHP_CodeSniffer\Files\File */
	private $testedCodeSnifferFile;

	public function testClassIsSuppressed()
	{
		self::assertTrue(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'IsSuppressed'), self::CHECK_NAME));
	}

	public function testClassIsNotSuppressed()
	{
		self::assertFalse(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findClassPointerByName($this->getTestedCodeSnifferFile(), 'IsNotSuppressed'), self::CHECK_NAME));
	}

	public function testConstantIsSuppressed()
	{
		self::assertTrue(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'IS_SUPPRESSED'), self::CHECK_NAME));
	}

	public function testConstantIsNotSuppressed()
	{
		self::assertFalse(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findConstantPointerByName($this->getTestedCodeSnifferFile(), 'IS_NOT_SUPPRESSED'), self::CHECK_NAME));
	}

	public function testPropertyIsSuppressed()
	{
		self::assertTrue(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'isSuppressed'), self::CHECK_NAME));
	}

	public function testPropertyIsNotSuppressed()
	{
		self::assertFalse(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findPropertyPointerByName($this->getTestedCodeSnifferFile(), 'isNotSuppressed'), self::CHECK_NAME));
	}

	/**
	 * @return string[][]
	 */
	public function dataFunctionIsSuppressed(): array
	{
		return [
			['suppressWithFullName'],
			['suppressWithPartialName'],
			['suppressWithFullDocComment'],
		];
	}

	/**
	 * @dataProvider dataFunctionIsSuppressed
	 * @param string $name
	 */
	public function testFunctionIsSuppressed(string $name)
	{
		self::assertTrue(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), $name), self::CHECK_NAME));
	}

	/**
	 * @return string[][]
	 */
	public function dataFunctionIsNotSuppressed(): array
	{
		return [
			['noDocComment'],
			['docCommentWithoutSuppress'],
			['invalidSuppress'],
		];
	}

	/**
	 * @dataProvider dataFunctionIsNotSuppressed
	 * @param string $name
	 */
	public function testFunctionIsNotSuppressed(string $name)
	{
		self::assertFalse(SuppressHelper::isSniffSuppressed($this->getTestedCodeSnifferFile(), $this->findFunctionPointerByName($this->getTestedCodeSnifferFile(), $name), self::CHECK_NAME));
	}

	private function getTestedCodeSnifferFile(): \PHP_CodeSniffer\Files\File
	{
		if ($this->testedCodeSnifferFile === null) {
			$this->testedCodeSnifferFile = $this->getCodeSnifferFile(
				__DIR__ . '/data/suppress.php'
			);
		}
		return $this->testedCodeSnifferFile;
	}

}
