<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\NamespaceHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use SlevomatCodingStandard\Helpers\UseStatementHelper;
use const T_AS;
use const T_OPEN_TAG;
use const T_SEMICOLON;
use const T_STRING;
use function count;
use function sprintf;

class UselessAliasSniff implements Sniff
{

	const CODE_USELESS_ALIAS = 'UselessAlias';

	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_OPEN_TAG,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $openTagPointer
	 */
	public function process(File $phpcsFile, $openTagPointer)
	{
		$useStatements = UseStatementHelper::getUseStatements($phpcsFile, $openTagPointer);

		if (count($useStatements) === 0) {
			return;
		}

		foreach ($useStatements as $useStatement) {
			if ($useStatement->getAlias() === null) {
				continue;
			}

			$unqualifiedName = NamespaceHelper::getUnqualifiedNameFromFullyQualifiedName($useStatement->getFullyQualifiedTypeName());
			if ($unqualifiedName !== $useStatement->getAlias()) {
				continue;
			}

			$fix = $phpcsFile->addFixableError(
				sprintf('Useless alias "%s" for use of "%s".', $useStatement->getAlias(), $useStatement->getFullyQualifiedTypeName()),
				$useStatement->getPointer(),
				self::CODE_USELESS_ALIAS
			);

			if (!$fix) {
				continue;
			}

			$asPointer = TokenHelper::findNext($phpcsFile, T_AS, $useStatement->getPointer() + 1);
			$nameEndPointer = TokenHelper::findPrevious($phpcsFile, T_STRING, $asPointer - 1);
			$useSemicolonPointer = TokenHelper::findNext($phpcsFile, T_SEMICOLON, $asPointer + 1);

			$phpcsFile->fixer->beginChangeset();
			for ($i = $nameEndPointer + 1; $i < $useSemicolonPointer; $i++) {
				$phpcsFile->fixer->replaceToken($i, '');
			}
			$phpcsFile->fixer->endChangeset();
		}
	}

}
