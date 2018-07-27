<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

use SlevomatCodingStandard\Sniffs\TestCase;

class ReferenceUsedNamesOnlySniffTest extends TestCase
{

	/**
	 * @return mixed[][]
	 */
	public function dataIgnoredNamesForIrrelevantTests(): array
	{
		return [
			[
				[],
			],
			[
				['LibXMLError'],
			],
		];
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotReportNamespaceName(array $ignoredNames)
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php', [
			'ignoredNames' => $ignoredNames,
		]);
		self::assertNoSniffError($report, 3);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testCreatingNewObjectViaNonFullyQualifiedName(array $ignoredNames)
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php', [
			'ignoredNames' => $ignoredNames,
		]);
		self::assertNoSniffError($report, 10);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testCreatingNewObjectViaFullyQualifiedName(array $ignoredNames)
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php', [
			'ignoredNames' => $ignoredNames,
		]);
		self::assertSniffError(
			$report,
			12,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Foo\SomeError'
		);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testReferencingClassConstantViaFullyQualifiedName(array $ignoredNames)
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php', [
			'ignoredNames' => $ignoredNames,
		]);
		self::assertSniffError(
			$report,
			11,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Some\ConstantClass'
		);
	}

	public function testReferencingConstantViaFullyQualifiedName()
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php');
		self::assertSniffError(
			$report,
			16,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Boo\FOO'
		);
	}

	public function testReferencingFunctionViaFullyQualifiedName()
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php');
		self::assertSniffError(
			$report,
			17,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Boo\foo'
		);
	}

	public function testReferencingGlobalFunctionViaFallback()
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php', [
			'allowFallbackGlobalFunctions' => false,
		]);
		self::assertSniffError(
			$report,
			18,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FALLBACK_GLOBAL_NAME,
			'min'
		);
	}

	public function testReferencingGlobalConstantViaFallback()
	{
		$report = self::checkFile(__DIR__ . '/data/shouldBeInUseStatement.php', [
			'allowFallbackGlobalConstants' => false,
		]);
		self::assertSniffError(
			$report,
			19,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FALLBACK_GLOBAL_NAME,
			'PHP_VERSION'
		);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testCreatingObjectFromSpecialExceptionName(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/shouldBeInUseStatement.php',
			[
				'allowFullyQualifiedExceptions' => true,
				'specialExceptionNames' => [
					'Foo\SomeError',
				],
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertNoSniffError($report, 12);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testReportFullyQualifiedInFileWithNamespace(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/shouldBeInUseStatement.php',
			[
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			13,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Some\CommonException'
		);
		self::assertSniffError(
			$report,
			14,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Exception'
		);
		self::assertSniffError(
			$report,
			15,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Nette\ObjectPrototype'
		);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotAllowFullyQualifiedExtends(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedExtends.php',
			[
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Lorem\Dolor'
		);
		self::assertNoSniffError($report, 8);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotAllowFullyQualifiedImplements(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedImplements.php',
			[
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\SomeClass'
		);
		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Some\OtherClass'
		);
		self::assertNoSniffError($report, 8);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testAllowFullyQualifiedExceptions(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedExceptionNames.php',
			[
				'allowFullyQualifiedExceptions' => true,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError(
			$report,
			28,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Foo\BarError'
		);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotAllowFullyQualifiedExceptionsInTypeHint(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedExceptionNames.php',
			[
				'allowFullyQualifiedExceptions' => false,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			16,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Some\Exception'
		);
		self::assertNoSniffError($report, 3);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotAllowFullyQualifiedExceptionsInThrow(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedExceptionNames.php',
			[
				'allowFullyQualifiedExceptions' => false,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			19,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Some\Other\Exception'
		);
		self::assertNoSniffError($report, 6);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotAllowFullyQualifiedExceptionsInCatch(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedExceptionNames.php',
			[
				'allowFullyQualifiedExceptions' => false,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			20,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Some\Other\DifferentException'
		);
		self::assertSniffError(
			$report,
			22,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\Throwable'
		);
		self::assertSniffError(
			$report,
			24,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\Exception'
		);
		self::assertSniffError(
			$report,
			26,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\TypeError'
		);
		self::assertSniffError(
			$report,
			28,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Foo\BarError'
		);
		self::assertNoSniffError($report, 7);
		self::assertNoSniffError($report, 9);
		self::assertNoSniffError($report, 11);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotAllowPartialUses(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/partialUses.php',
			[
				'allowPartialUses' => false,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			7,
			ReferenceUsedNamesOnlySniff::CODE_PARTIAL_USE,
			'SomeFramework\ObjectPrototype'
		);
		self::assertNoSniffError($report, 6);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testAllowPartialUses(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/partialUses.php',
			[
				'allowPartialUses' => true,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertNoSniffError($report, 6);
		self::assertNoSniffError($report, 7);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testUseOnlyWhitelistedNamespaces(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/whitelistedNamespaces.php',
			[
				'namespacesRequiredToUse' => [
					'Foo',
				],
				'ignoredNames' => $ignoredNames,
			]
		);

		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Foo\Bar'
		);
		self::assertNoSniffError($report, 4);
		self::assertNoSniffError($report, 5);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testAllowFullyQualifiedImplementsWithMultipleInterfaces(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/multipleFullyQualifiedImplements.php',
			[
				'fullyQualifiedKeywords' => ['T_IMPLEMENTS'],
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertNoSniffErrorInFile($report);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDisallowFullyQualifiedImplementsWithMultipleInterfaces(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/multipleFullyQualifiedImplements.php',
			[
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\Bar'
		);
		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\Baz'
		);
		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Foo\Baz'
		);
	}

	/**
	 * @dataProvider dataIgnoredNamesForIrrelevantTests
	 * @param string[] $ignoredNames
	 */
	public function testDoNotUseTypeInRootNamespaceInFileWithoutNamespace(array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/referencingFullyQualifiedNameInFileWithoutNamespace.php',
			[
				'ignoredNames' => $ignoredNames,
			]
		);

		self::assertSniffError(
			$report,
			3,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE,
			'\Foo'
		);
		self::assertSniffError(
			$report,
			4,
			ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME,
			'\Bar\Lorem'
		);
	}

	/**
	 * @return mixed[][]
	 */
	public function dataIgnoredNames(): array
	{
		return [
			[
				false,
				[],
			],
			[
				true,
				[
					'LibXMLError',
					'LibXMLException',
				],
			],
		];
	}

	/**
	 * @dataProvider dataIgnoredNames
	 * @param bool $allowFullyQualifiedExceptions
	 * @param string[] $ignoredNames
	 */
	public function testIgnoredNames(bool $allowFullyQualifiedExceptions, array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/ignoredNames.php',
			[
				'allowFullyQualifiedExceptions' => $allowFullyQualifiedExceptions,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertNoSniffError($report, 3);
		self::assertNoSniffError($report, 7);
		self::assertSniffError($report, 11, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE);
		self::assertSniffError($report, 15, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE);
	}

	public function testIgnoredNamesWithAllowFullyQualifiedExceptions()
	{
		$report = self::checkFile(
			__DIR__ . '/data/ignoredNames.php',
			['allowFullyQualifiedExceptions' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	/**
	 * @return mixed[][]
	 */
	public function dataIgnoredNamesInNamespace(): array
	{
		return [
			[
				false,
				[],
			],
			[
				true,
				[
					'LibXMLError',
					'LibXMLException',
				],
			],
		];
	}

	/**
	 * @dataProvider dataIgnoredNamesInNamespace
	 * @param bool $allowFullyQualifiedExceptions
	 * @param string[] $ignoredNames
	 */
	public function testIgnoredNamesInNamespace(bool $allowFullyQualifiedExceptions, array $ignoredNames)
	{
		$report = self::checkFile(
			__DIR__ . '/data/ignoredNamesInNamespace.php',
			[
				'allowFullyQualifiedExceptions' => $allowFullyQualifiedExceptions,
				'ignoredNames' => $ignoredNames,
			]
		);
		self::assertNoSniffError($report, 5);
		self::assertNoSniffError($report, 9);
		self::assertSniffError($report, 13, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
		self::assertSniffError($report, 17, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testIgnoredNamesWithAllowFullyQualifiedExceptionsInNamespace()
	{
		$report = self::checkFile(
			__DIR__ . '/data/ignoredNamesInNamespace.php',
			['allowFullyQualifiedExceptions' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testThrowExceptionForUndefinedKeyword()
	{
		$this->expectException(UndefinedKeywordTokenException::class);
		$this->expectExceptionMessage('Value for keyword token not found, constant "T_FOO" is not defined');

		self::checkFile(
			__DIR__ . '/data/unknownKeyword.php',
			['fullyQualifiedKeywords' => ['T_FOO']]
		);
	}

	public function testAllowingFullyQualifiedGlobalClasses()
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedGlobalClassesInNamespace.php',
			[
				'allowFullyQualifiedGlobalClasses' => true,
				'allowFullyQualifiedGlobalFunctions' => false,
				'allowFullyQualifiedGlobalConstants' => false,
			]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testAllowingFullyQualifiedGlobalFunctions()
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedGlobalFunctionsInNamespace.php',
			[
				'allowFullyQualifiedGlobalClasses' => false,
				'allowFullyQualifiedGlobalFunctions' => true,
				'allowFullyQualifiedGlobalConstants' => false,
			]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testAllowingFullyQualifiedGlobalConstants()
	{
		$report = self::checkFile(
			__DIR__ . '/data/fullyQualifiedGlobalConstantsInNamespace.php',
			[
				'allowFullyQualifiedGlobalClasses' => false,
				'allowFullyQualifiedGlobalFunctions' => false,
				'allowFullyQualifiedGlobalConstants' => true,
			]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testFixableReferenceViaFullyQualifiedOrGlobalFallbackName()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableReferenceViaFullyQualifiedName.php', [
			'fullyQualifiedKeywords' => ['T_EXTENDS'],
			'allowFullyQualifiedExceptions' => true,
			'allowFallbackGlobalFunctions' => false,
			'allowFallbackGlobalConstants' => false,
		], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FALLBACK_GLOBAL_NAME]);
		self::assertAllFixedInFile($report);
	}

	public function testNotFixableReferenceViaFullyQualifiedName()
	{
		$report = self::checkFile(__DIR__ . '/data/notFixableReferenceViaFullyQualifiedName.php', [], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME]);
		self::assertAllFixedInFile($report);
	}

	public function testPartlyFixableReferenceViaFullyQualifiedName()
	{
		$report = self::checkFile(__DIR__ . '/data/partlyFixableReferenceViaFullyQualifiedName.php', [], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME]);
		self::assertAllFixedInFile($report);
	}

	public function testFixableReferenceViaFullyQualifiedNameNoUseStatements()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableReferenceViaFullyQualifiedNameNoUseStatements.php', [
			'fullyQualifiedKeywords' => ['T_EXTENDS', 'T_IMPLEMENTS'],
		], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME]);
		self::assertAllFixedInFile($report);
	}

	public function testFixableReferenceViaFullyQualifiedNameNoUseStatementsAndNoNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableReferenceViaFullyQualifiedNameNoUseStatementsAndNoNamespace.php', [
			'fullyQualifiedKeywords' => ['T_EXTENDS', 'T_IMPLEMENTS'],
		], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME]);
		self::assertAllFixedInFile($report);
	}

	public function testFixableReferenceViaFullyQualifiedNameNoUseStatementsAndNoNamespaceAndDeclare()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableReferenceViaFullyQualifiedNameNoUseStatementsAndNoNamespaceAndDeclare.php', [
			'fullyQualifiedKeywords' => ['T_EXTENDS', 'T_IMPLEMENTS'],
		], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME]);
		self::assertAllFixedInFile($report);
	}

	public function testFixableReferenceViaFullyQualifiedNameWithoutNamespace()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableReferenceViaFullyQualifiedNameWithoutNamespace.php', [
			'fullyQualifiedKeywords' => ['T_IMPLEMENTS'],
			'allowFullyQualifiedExceptions' => false,
			'specialExceptionNames' => [
				'BarErrorX',
			],
			'searchAnnotations' => true,
		], [ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME_WITHOUT_NAMESPACE]);
		self::assertAllFixedInFile($report);
	}

	public function testCollidingClassNameDifferentNamespacesAllowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingClassNameDifferentNamespaces.php',
			['allowFullyQualifiedNameForCollidingClasses' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testCollidingClassNameDifferentNamespacesDisallowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingClassNameDifferentNamespaces.php',
			['allowFullyQualifiedNameForCollidingClasses' => false]
		);

		self::assertSame(2, $report->getErrorCount());

		self::assertSniffError($report, 14, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
		self::assertSniffError($report, 16, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testCollidingClassNameDifferentNamespacesMoreClassesAllowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingClassNameDifferentNamespacesMoreClasses.php',
			['allowFullyQualifiedNameForCollidingClasses' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testCollidingClassNameDifferentNamespacesMoreClassesDisallowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingClassNameDifferentNamespacesMoreClasses.php',
			['allowFullyQualifiedNameForCollidingClasses' => false]
		);

		self::assertSame(4, $report->getErrorCount());

		self::assertSniffError($report, 7, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
		self::assertSniffError($report, 9, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
		self::assertSniffError($report, 12, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
		self::assertSniffError($report, 14, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testFixableWhenCollidingClassNames()
	{
		$report = self::checkFile(
			__DIR__ . '/data/fixableWhenCollidingClassNames.php',
			[
				'searchAnnotations' => true,
				'allowFullyQualifiedNameForCollidingClasses' => true,
				'allowFullyQualifiedGlobalClasses' => true,
				'allowFullyQualifiedGlobalFunctions' => true,
				'allowFullyQualifiedGlobalConstants' => true,
			]
		);

		self::assertAllFixedInFile($report);
	}

	public function testCollidingClassNameExtendsAllowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingClassNameExtends.php',
			['allowFullyQualifiedNameForCollidingClasses' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testCollidingClassNameExtendsDisabled()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingClassNameExtends.php',
			['allowFullyQualifiedNameForCollidingClasses' => false]
		);
		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 5, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testCollidingFullyQualifiedFunctionNameAllowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingFullyQualifiedFunctionNames.php',
			['allowFullyQualifiedNameForCollidingFunctions' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testCollidingFullyQualifiedFunctionNameDisallowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingFullyQualifiedFunctionNames.php',
			['allowFullyQualifiedNameForCollidingFunctions' => false]
		);

		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 15, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testCollidingFullyQualifiedConstantNameAllowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingFullyQualifiedConstantNames.php',
			['allowFullyQualifiedNameForCollidingConstants' => true]
		);
		self::assertNoSniffErrorInFile($report);
	}

	public function testCollidingFullyQualifiedConstantNameDisallowed()
	{
		$report = self::checkFile(
			__DIR__ . '/data/collidingFullyQualifiedConstantNames.php',
			['allowFullyQualifiedNameForCollidingConstants' => false]
		);

		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 12, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testReferencingGlobalFunctionViaFallbackErrorsWithMoreComplexSettings()
	{
		$report = self::checkFile(
			__DIR__ . '/data/referencingGlobalFunctionViaFallbackErrorsWithMoreComplexSettings.php',
			[
				'allowFallbackGlobalFunctions' => false,
				'allowFullyQualifiedNameForCollidingFunctions' => true,
				'allowFullyQualifiedGlobalFunctions' => true,
			]
		);

		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 17, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FALLBACK_GLOBAL_NAME);
	}

	public function testReferencingGlobalFunctionViaFullyQualifiedWithMoreComplexSettings()
	{
		$report = self::checkFile(
			__DIR__ . '/data/referencingGlobalFunctionViaFullyQualifiedWithMoreComplexSettings.php',
			[
				'allowFallbackGlobalFunctions' => false,
				'allowFullyQualifiedNameForCollidingFunctions' => true,
				'allowFullyQualifiedGlobalFunctions' => false,
			]
		);

		self::assertSame(1, $report->getErrorCount());
		self::assertSniffError($report, 13, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME);
	}

	public function testSearchingInAnnotationsDisabled()
	{
		$report = self::checkFile(
			__DIR__ . '/data/shouldBeInUseStatementSearchingInAnnotations.php',
			[
				'searchAnnotations' => false,
			]
		);

		self::assertNoSniffErrorInFile($report);
	}

	public function testSearchingInAnnotations()
	{
		$report = self::checkFile(
			__DIR__ . '/data/shouldBeInUseStatementSearchingInAnnotations.php',
			[
				'searchAnnotations' => true,
				'allowPartialUses' => false,
				'allowFullyQualifiedGlobalClasses' => true,
				'allowFullyQualifiedNameForCollidingClasses' => true,
				'allowFullyQualifiedExceptions' => false,
				'namespacesRequiredToUse' => ['Foo'],
			]
		);

		self::assertSame(9, $report->getErrorCount());

		self::assertSniffError($report, 10, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\DateTime should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 14, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\DateTime should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 29, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\ArrayObject should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 31, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\Something should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 32, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\Exception should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 36, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\Traversable should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 42, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\Something should not be referenced via a fully qualified name, but via a use statement.');
		self::assertSniffError($report, 49, ReferenceUsedNamesOnlySniff::CODE_REFERENCE_VIA_FULLY_QUALIFIED_NAME, 'Class \Foo\Something should not be referenced via a fully qualified name, but via a use statement.');

		self::assertSniffError($report, 38, ReferenceUsedNamesOnlySniff::CODE_PARTIAL_USE);

		self::assertAllFixedInFile($report);
	}

	public function testReferencingGlobalTypesInGlobalNamespace()
	{
		$report = self::checkFile(
			__DIR__ . '/data/referencingGlobalTypesInGlobalNamespace.php',
			[
				'allowFallbackGlobalFunctions' => false,
				'allowFallbackGlobalConstants' => false,
			]
		);

		self::assertNoSniffErrorInFile($report);
	}

}
