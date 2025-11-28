<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests\Request;

use MSpirkov\Yii2\Web\Request;
use PHPUnit\Framework\TestCase;
use yii\web\BadRequestHttpException;

class RequestTest extends TestCase
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetIntWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetIntWithException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getGetInt(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostIntWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostIntWithException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getPostInt(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetFloatWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetFloatWithException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getGetFloat(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostFloatWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostFloatWithException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getPostFloat(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetBoolWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetBoolWithException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getGetBool(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetBoolWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostBoolWithException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getPostBool(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetStringWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetGetStringWithException($paramValue): void
    {
        $this->setQueryParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getGetString(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetStringWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostStringWithException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getPostString(RequestDataProvider::TEST_PARAM_NAME);
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
     * @dataProvider MSpirkov\Yii2\Web\Tests\Request\RequestDataProvider::provideGetPostArrayWithExceptionData
     *
     * @param mixed $paramValue
     */
    public function testGetPostArrayWithException($paramValue): void
    {
        $this->setBodyParams($paramValue);
        $this->expectBadRequestException();
        $this->request->getPostArray(RequestDataProvider::TEST_PARAM_NAME);
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

    private function expectBadRequestException(): void
    {
        $this->expectExceptionObject(
            new BadRequestHttpException('Invalid value for parameter: ' . RequestDataProvider::TEST_PARAM_NAME)
        );
    }
}
