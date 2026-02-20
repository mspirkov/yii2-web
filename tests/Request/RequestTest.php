<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests\Request;

use MSpirkov\Yii2\Web\Request;
use MSpirkov\Yii2\Web\Tests\AbstractTestCase;
use yii\web\BadRequestHttpException;

class RequestTest extends AbstractTestCase
{
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetGetIntData
     *
     * @param mixed $paramValue
     */
    public function testGetGetInt(
        $paramValue,
        string $paramName,
        ?int $defaultValue,
        ?int $expectedResult
    ): void {
        $this->setQueryParams($paramValue);
        self::assertSame($expectedResult, $this->request->getGetInt($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetIntWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetIntWithInvalidParamException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getGetInt(RequestDataProvider::TEST_PARAM_NAME);
    }

    /**
     * @testWith [""]
     *           [null]
     */
    public function testGetGetIntWithMissingParamException(?string $paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectMissingParamException();
        $this->request->getGetInt(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetIntData
     *
     * @param mixed $paramValue
     */
    public function testGetPostInt(
        $paramValue,
        string $paramName,
        ?int $defaultValue,
        ?int $expectedResult
    ): void {
        $this->setBodyParams($paramValue);
        self::assertSame($expectedResult, $this->request->getPostInt($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostIntWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostIntWithInvalidParamException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getPostInt(RequestDataProvider::TEST_PARAM_NAME);
    }

    public function testGetPostIntWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getPostInt(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetGetFloatData
     *
     * @param mixed $paramValue
     */
    public function testGetGetFloat(
        $paramValue,
        string $paramName,
        ?float $defaultValue,
        ?float $expectedResult
    ): void {
        $this->setQueryParams($paramValue);
        self::assertSame($expectedResult, $this->request->getGetFloat($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetFloatWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetFloatWithInvalidParamException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getGetFloat(RequestDataProvider::TEST_PARAM_NAME);
    }

    /**
     * @testWith [""]
     *           [null]
     */
    public function testGetGetFloatWithMissingParamException(?string $paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectMissingParamException();
        $this->request->getGetFloat(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetFloatData
     *
     * @param mixed $paramValue
     */
    public function testGetPostFloat(
        $paramValue,
        string $paramName,
        ?float $defaultValue,
        ?float $expectedResult
    ): void {
        $this->setBodyParams($paramValue);
        self::assertSame($expectedResult, $this->request->getPostFloat($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostFloatWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostFloatWithInvalidParamException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getPostFloat(RequestDataProvider::TEST_PARAM_NAME);
    }

    public function testGetPostFloatWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getPostFloat(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetGetBoolData
     *
     * @param mixed $paramValue
     */
    public function testGetGetBool(
        $paramValue,
        string $paramName,
        ?bool $defaultValue,
        ?bool $expectedResult
    ): void {
        $this->setQueryParams($paramValue);
        self::assertSame($expectedResult, $this->request->getGetBool($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetBoolWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetBoolWithInvalidParamException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getGetBool(RequestDataProvider::TEST_PARAM_NAME);
    }

    /**
     * @testWith [""]
     *           [null]
     */
    public function testGetGetBoolWithMissingParamException(?string $paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectMissingParamException();
        $this->request->getGetBool(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostBoolData
     *
     * @param mixed $paramValue
     */
    public function testGetPostBool(
        $paramValue,
        string $paramName,
        ?bool $defaultValue,
        ?bool $expectedResult
    ): void {
        $this->setBodyParams($paramValue);
        self::assertSame($expectedResult, $this->request->getPostBool($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetBoolWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostBoolWithInvalidParamException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getPostBool(RequestDataProvider::TEST_PARAM_NAME);
    }

    public function testGetPostBoolWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getPostBool(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetStringData
     *
     * @param mixed $paramValue
     */
    public function testGetGetString(
        $paramValue,
        string $paramName,
        ?string $defaultValue,
        ?string $expectedResult
    ): void {
        $this->setQueryParams($paramValue);
        self::assertSame($expectedResult, $this->request->getGetString($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetStringWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetStringWithInvalidParamException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getGetString(RequestDataProvider::TEST_PARAM_NAME);
    }

    public function testGetGetStringWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getGetString(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetStringData
     *
     * @param mixed $paramValue
     */
    public function testGetPostString(
        $paramValue,
        string $paramName,
        ?string $defaultValue,
        ?string $expectedResult
    ): void {
        $this->setBodyParams($paramValue);
        self::assertSame($expectedResult, $this->request->getPostString($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetStringWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostStringWithInvalidParamException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getPostString(RequestDataProvider::TEST_PARAM_NAME);
    }

    public function testGetPostStringWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getPostString(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetGetArrayData
     *
     * @param mixed $paramValue
     * @param mixed[]|null $defaultValue
     * @param mixed[]|null $expectedResult
     */
    public function testGetGetArray(
        $paramValue,
        string $paramName,
        ?array $defaultValue,
        ?array $expectedResult
    ): void {
        $this->setQueryParams($paramValue);
        self::assertSame($expectedResult, $this->request->getGetArray($paramName, $defaultValue));
    }

    public function testGetGetArrayWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getGetArray(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetArrayData
     *
     * @param mixed $paramValue
     * @param mixed[]|null $defaultValue
     * @param mixed[]|null $expectedResult
     */
    public function testGetPostArray(
        $paramValue,
        string $paramName,
        ?array $defaultValue,
        ?array $expectedResult
    ): void {
        $this->setBodyParams($paramValue);
        self::assertSame($expectedResult, $this->request->getPostArray($paramName, $defaultValue));
    }

    /**
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostArrayWithInvalidParamExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostArrayWithInvalidParamException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectInvalidParamException();
        $this->request->getPostArray(RequestDataProvider::TEST_PARAM_NAME);
    }

    public function testGetPostArrayWithMissingParamException(): void
    {
        $this->expectMissingParamException();
        $this->request->getPostArray(RequestDataProvider::TEST_PARAM_NAME, null, true);
    }

    /**
     * @param mixed $paramValue
     */
    private function setQueryParams($paramValue): void
    {
        $this->request->setQueryParams([RequestDataProvider::TEST_PARAM_NAME => $paramValue]);
    }

    /**
     * @param mixed $paramValue
     */
    private function setBodyParams($paramValue): void
    {
        $this->request->setBodyParams([RequestDataProvider::TEST_PARAM_NAME => $paramValue]);
    }

    private function expectMissingParamException(): void
    {
        $this->expectExceptionObject(
            new BadRequestHttpException('Missing required parameter: ' . RequestDataProvider::TEST_PARAM_NAME)
        );
    }

    private function expectInvalidParamException(): void
    {
        $this->expectExceptionObject(
            new BadRequestHttpException('Invalid value for parameter: ' . RequestDataProvider::TEST_PARAM_NAME)
        );
    }
}
