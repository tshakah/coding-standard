<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Operators;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\TokenHelper;
use const T_DEC;
use const T_INC;
use const T_VARIABLE;

class DisallowIncrementAndDecrementOperatorsSniff implements Sniff
{

	const CODE_DISALLOWED_PRE_INCREMENT_OPERATOR = 'DisallowedPreIncrementOperator';
	const CODE_DISALLOWED_POST_INCREMENT_OPERATOR = 'DisallowedPostIncrementOperator';
	const CODE_DISALLOWED_PRE_DECREMENT_OPERATOR = 'DisallowedPreDecrementOperator';
	const CODE_DISALLOWED_POST_DECREMENT_OPERATOR = 'DisallowedPostDecrementOperator';

	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_DEC,
			T_INC,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $operatorPointer
	 */
	public function process(File $phpcsFile, $operatorPointer)
	{
		$tokens = $phpcsFile->getTokens();

		$previousPointer = TokenHelper::findPreviousEffective($phpcsFile, $operatorPointer - 1);

		$isPostOperator = $tokens[$previousPointer]['code'] === T_VARIABLE;

		if ($tokens[$operatorPointer]['code'] === T_INC) {
			if ($isPostOperator) {
				$code = self::CODE_DISALLOWED_POST_INCREMENT_OPERATOR;
				$message = 'Use of post-increment operator is disallowed.';
			} else {
				$code = self::CODE_DISALLOWED_PRE_INCREMENT_OPERATOR;
				$message = 'Use of pre-increment operator is disallowed.';
			}
		} else {
			if ($isPostOperator) {
				$code = self::CODE_DISALLOWED_POST_DECREMENT_OPERATOR;
				$message = 'Use of post-decrement operator is disallowed.';
			} else {
				$code = self::CODE_DISALLOWED_PRE_DECREMENT_OPERATOR;
				$message = 'Use of pre-decrement operator is disallowed.';
			}
		}

		$phpcsFile->addError($message, $operatorPointer, $code);
	}

}
