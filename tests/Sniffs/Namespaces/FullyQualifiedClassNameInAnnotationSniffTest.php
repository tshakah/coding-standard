<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Namespaces;

class FullyQualifiedClassNameInAnnotationSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoErrors()
	{
		self::assertNoSniffErrorInFile(self::checkFile(__DIR__ . '/data/fullyQualifiedClassNameInAnnotationNoErrors.php'));
	}

	public function testErrors()
	{
		$report = self::checkFile(__DIR__ . '/data/fullyQualifiedClassNameInAnnotationErrors.php');

		self::assertSame(12, $report->getErrorCount());

		self::assertSniffError($report, 13, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 17, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 22, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 26, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 31, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 32, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 40, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 41, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 49, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
		self::assertSniffError($report, 57, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME, 'Class name \FooNamespace\FooClass in @return should be referenced via a fully qualified name');
		self::assertSniffError($report, 57, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME, 'Class name \Iterator in @return should be referenced via a fully qualified name');
		self::assertSniffError($report, 61, FullyQualifiedClassNameInAnnotationSniff::CODE_NON_FULLY_QUALIFIED_CLASS_NAME);
	}

	public function testFixableFullyQualified()
	{
		$report = self::checkFile(__DIR__ . '/data/fixableFullyQualifiedClassNameInAnnotation.php');
		self::assertAllFixedInFile($report);
	}

}
