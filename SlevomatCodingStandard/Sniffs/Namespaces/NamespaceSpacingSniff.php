<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\SniffSettingsHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use const T_COMMENT;
use const T_NAMESPACE;
use const T_OPEN_TAG;
use const T_SEMICOLON;
use const T_WHITESPACE;
use function array_key_exists;
use function array_merge;
use function in_array;
use function rtrim;
use function sprintf;
use function strlen;
use function substr;
use function substr_count;

class NamespaceSpacingSniff implements Sniff
{

	const CODE_INCORRECT_LINES_COUNT_BEFORE_NAMESPACE = 'IncorrectLinesCountBeforeNamespace';
	const CODE_INCORRECT_LINES_COUNT_AFTER_NAMESPACE = 'IncorrectLinesCountAfterNamespace';

	/** @var int */
	public $linesCountBeforeNamespace = 1;

	/** @var int */
	public $linesCountAfterNamespace = 1;

	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_NAMESPACE,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $namespacePointer
	 */
	public function process(File $phpcsFile, $namespacePointer)
	{
		$this->checkLinesBeforeNamespace($phpcsFile, $namespacePointer);
		$this->checkLinesAfterNamespace($phpcsFile, $namespacePointer);
	}

	private function checkLinesBeforeNamespace(File $phpcsFile, int $namespacePointer)
	{
		$tokens = $phpcsFile->getTokens();

		/** @var int $pointerBeforeNamespace */
		$pointerBeforeNamespace = TokenHelper::findPreviousExcluding($phpcsFile, T_WHITESPACE, $namespacePointer - 1);

		$whitespaceBeforeNamespace = '';

		$commentTokensWithEolChar = array_merge([T_COMMENT], Tokens::$phpcsCommentTokens);

		if ($tokens[$pointerBeforeNamespace]['code'] === T_OPEN_TAG) {
			$whitespaceBeforeNamespace .= substr($tokens[$pointerBeforeNamespace]['content'], strlen('<?php'));
		} elseif (in_array($tokens[$pointerBeforeNamespace]['code'], $commentTokensWithEolChar, true)) {
			$whitespaceBeforeNamespace .= $phpcsFile->eolChar;
		}

		if ($pointerBeforeNamespace + 1 !== $namespacePointer) {
			$whitespaceBeforeNamespace .= TokenHelper::getContent($phpcsFile, $pointerBeforeNamespace + 1, $namespacePointer - 1);
		}

		$requiredLinesCountBeforeNamespace = SniffSettingsHelper::normalizeInteger($this->linesCountBeforeNamespace);
		$actualLinesCountBeforeNamespace = substr_count($whitespaceBeforeNamespace, $phpcsFile->eolChar) - 1;

		if ($actualLinesCountBeforeNamespace === $requiredLinesCountBeforeNamespace) {
			return;
		}

		$fix = $phpcsFile->addFixableError(
			sprintf(
				'Expected %d lines before namespace statement, found %d.',
				$requiredLinesCountBeforeNamespace,
				$actualLinesCountBeforeNamespace
			),
			$namespacePointer,
			self::CODE_INCORRECT_LINES_COUNT_BEFORE_NAMESPACE
		);

		if (!$fix) {
			return;
		}

		$phpcsFile->fixer->beginChangeset();

		if ($tokens[$pointerBeforeNamespace]['code'] === T_OPEN_TAG) {
			$phpcsFile->fixer->replaceToken($pointerBeforeNamespace, '<?php');
		} elseif (in_array($tokens[$pointerBeforeNamespace]['code'], $commentTokensWithEolChar, true)) {
			$phpcsFile->fixer->replaceToken($pointerBeforeNamespace, rtrim($tokens[$pointerBeforeNamespace]['content'], $phpcsFile->eolChar));
		}

		for ($i = $pointerBeforeNamespace + 1; $i < $namespacePointer; $i++) {
			$phpcsFile->fixer->replaceToken($i, '');
		}
		for ($i = 0; $i <= $requiredLinesCountBeforeNamespace; $i++) {
			$phpcsFile->fixer->addNewline($pointerBeforeNamespace);
		}
		$phpcsFile->fixer->endChangeset();
	}

	private function checkLinesAfterNamespace(File $phpcsFile, int $namespacePointer)
	{
		if (array_key_exists('scope_opener', $phpcsFile->getTokens()[$namespacePointer])) {
			return;
		}

		/** @var int $namespaceSemicolonPointer */
		$namespaceSemicolonPointer = TokenHelper::findNextLocal($phpcsFile, T_SEMICOLON, $namespacePointer + 1);

		$pointerAfterWhitespaceEnd = TokenHelper::findNextExcluding($phpcsFile, T_WHITESPACE, $namespaceSemicolonPointer + 1);
		if ($pointerAfterWhitespaceEnd === null) {
			return;
		}

		$whitespaceAfterNamespace = TokenHelper::getContent($phpcsFile, $namespaceSemicolonPointer + 1, $pointerAfterWhitespaceEnd - 1);

		$requiredLinesCountAfterNamespace = SniffSettingsHelper::normalizeInteger($this->linesCountAfterNamespace);
		$actualLinesCountAfterNamespace = substr_count($whitespaceAfterNamespace, $phpcsFile->eolChar) - 1;

		if ($actualLinesCountAfterNamespace === $requiredLinesCountAfterNamespace) {
			return;
		}

		$fix = $phpcsFile->addFixableError(
			sprintf(
				'Expected %d lines after namespace statement, found %d.',
				$requiredLinesCountAfterNamespace,
				$actualLinesCountAfterNamespace
			),
			$namespacePointer,
			self::CODE_INCORRECT_LINES_COUNT_AFTER_NAMESPACE
		);

		if (!$fix) {
			return;
		}

		$phpcsFile->fixer->beginChangeset();
		for ($i = $namespaceSemicolonPointer + 1; $i < $pointerAfterWhitespaceEnd; $i++) {
			$phpcsFile->fixer->replaceToken($i, '');
		}
		for ($i = 0; $i <= $requiredLinesCountAfterNamespace; $i++) {
			$phpcsFile->fixer->addNewline($namespaceSemicolonPointer);
		}
		$phpcsFile->fixer->endChangeset();
	}

}
