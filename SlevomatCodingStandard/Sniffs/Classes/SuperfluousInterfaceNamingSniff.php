<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;
use const T_INTERFACE;
use function sprintf;
use function strtolower;
use function substr;

class SuperfluousInterfaceNamingSniff implements Sniff
{

	const CODE_SUPERFLUOUS_PREFIX = 'SuperfluousPrefix';
	const CODE_SUPERFLUOUS_SUFFIX = 'SuperfluousSuffix';

	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_INTERFACE,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $interfacePointer
	 */
	public function process(File $phpcsFile, $interfacePointer)
	{
		$interfaceName = ClassHelper::getName($phpcsFile, $interfacePointer);

		$this->checkPrefix($phpcsFile, $interfacePointer, $interfaceName);
		$this->checkSuffix($phpcsFile, $interfacePointer, $interfaceName);
	}

	private function checkPrefix(File $phpcsFile, int $interfacePointer, string $interfaceName)
	{
		$prefix = substr($interfaceName, 0, 9);

		if (strtolower($prefix) !== 'interface') {
			return;
		}

		$phpcsFile->addError(sprintf('Superfluous prefix "%s".', $prefix), $interfacePointer, self::CODE_SUPERFLUOUS_PREFIX);
	}

	private function checkSuffix(File $phpcsFile, int $interfacePointer, string $interfaceName)
	{
		$suffix = substr($interfaceName, -9);

		if (strtolower($suffix) !== 'interface') {
			return;
		}

		$phpcsFile->addError(sprintf('Superfluous suffix "%s".', $suffix), $interfacePointer, self::CODE_SUPERFLUOUS_SUFFIX);
	}

}
