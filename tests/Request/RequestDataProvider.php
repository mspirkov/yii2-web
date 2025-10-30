<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests\Request;

class RequestDataProvider
{
    public const TEST_PARAM_NAME = 'requestTestTest';
    public const TEST_IP = '192.52.193.0';

    /**
     * @return array{
     *     mixed,
     *     string,
     *     int|null,
     *     int|null,
     * }[]
     */
    public static function provideGetIntData(): array
    {
        return [
            [null, 'unknown', null, null],
            [null, 'unknown', 0, 0],
            [true, self::TEST_PARAM_NAME, null, 1],
            [100, self::TEST_PARAM_NAME, null, 100],
            ['1', self::TEST_PARAM_NAME, null, 1],
        ];
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     int|null,
     *     int|null,
     * }[]
     */
    public static function provideGetGetIntData(): array
    {
        return array_merge(self::provideGetIntData(), [
            ['', self::TEST_PARAM_NAME, null, null],
        ]);
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetIntWithExceptionData(): array
    {
        return [
            ['1afg'],
            [false],
            ['10.55'],
            [10.55],
            [[]],
        ];
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetPostIntWithExceptionData(): array
    {
        return array_merge(self::provideGetIntWithExceptionData(), [
            [''],
        ]);
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     float|null,
     *     float|null,
     * }[]
     */
    public static function provideGetFloatData(): array
    {
        return [
            [null, 'unknown', null, null],
            [null, 'unknown', 0, 0],
            [true, self::TEST_PARAM_NAME, null, 1],
            [100, self::TEST_PARAM_NAME, null, 100],
            [100.55, self::TEST_PARAM_NAME, null, 100.55],
            ['1', self::TEST_PARAM_NAME, null, 1],
            ['99.99', self::TEST_PARAM_NAME, null, 99.99],
        ];
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     float|null,
     *     float|null,
     * }[]
     */
    public static function provideGetGetFloatData(): array
    {
        return array_merge(self::provideGetFloatData(), [
            ['', self::TEST_PARAM_NAME, null, null],
        ]);
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetFloatWithExceptionData(): array
    {
        return [
            ['1afg'],
            ['99,99'],
            [false],
            [[]],
        ];
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetPostFloatWithExceptionData(): array
    {
        return array_merge(self::provideGetFloatWithExceptionData(), [
            [''],
        ]);
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     bool|null,
     *     bool|null,
     * }[]
     */
    public static function provideGetGetBoolData(): array
    {
        return array_merge(self::provideGetBoolData(), [
            ['', self::TEST_PARAM_NAME, null, null],
        ]);
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     bool|null,
     *     bool|null,
     * }[]
     */
    public static function provideGetPostBoolData(): array
    {
        return array_merge(self::provideGetBoolData(), [
            ['', self::TEST_PARAM_NAME, null, false],
        ]);
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetBoolWithExceptionData(): array
    {
        return [
            ['100'],
            ['100.55'],
            ['abc'],
            [100.55],
            [10],
            [[]],
        ];
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     string|null,
     *     string|null,
     * }[]
     */
    public static function provideGetStringData(): array
    {
        return [
            [null, 'unknown', null, null],
            [null, 'unknown', 'test', 'test'],
            ['', self::TEST_PARAM_NAME, null, ''],
            [1, self::TEST_PARAM_NAME, null, '1'],
            [1.05, self::TEST_PARAM_NAME, null, '1.05'],
            [true, self::TEST_PARAM_NAME, null, '1'],
            [false, self::TEST_PARAM_NAME, null, ''],
            ['1', self::TEST_PARAM_NAME, null, '1'],
            ['abc', self::TEST_PARAM_NAME, null, 'abc'],
        ];
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetStringWithExceptionData(): array
    {
        return [
            [[]],
        ];
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     mixed[]|null,
     *     mixed[]|null,
     * }[]
     */
    public static function provideGetArrayData(): array
    {
        return [
            [null, 'unknown', null, null],
            ['', 'unknown', null, null],
            [['123'], 'unknown', null, null],
            [null, 'unknown', ['test'], ['test']],
            [['abc' => 'cba'], self::TEST_PARAM_NAME, null, ['abc' => 'cba']],
            [['123', '321'], self::TEST_PARAM_NAME, null, ['123', '321']],
        ];
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     mixed[]|null,
     *     mixed[]|null,
     * }[]
     */
    public static function provideGetGetArrayData(): array
    {
        return array_merge(self::provideGetArrayData(), [
            ['1', self::TEST_PARAM_NAME, null, ['1']],
            [1, self::TEST_PARAM_NAME, null, [1]],
            [1.5, self::TEST_PARAM_NAME, null, [1.5]],
            ['abc', self::TEST_PARAM_NAME, null, ['abc']],
            ['', self::TEST_PARAM_NAME, null, ['']],
        ]);
    }

    /**
     * @return array{mixed}[]
     */
    public static function provideGetPostArrayWithExceptionData(): array
    {
        return [
            [1],
            [''],
            [1.5],
            [false],
            [true],
        ];
    }

    /**
     * @return array{
     *     mixed,
     *     string,
     *     bool|null,
     *     bool|null,
     * }[]
     */
    private static function provideGetBoolData(): array
    {
        return [
            [null, 'unknown', null, null],
            [null, 'unknown', false, false],
            ['1', self::TEST_PARAM_NAME, null, true],
            ['0', self::TEST_PARAM_NAME, null, false],
            ['true', self::TEST_PARAM_NAME, null, true],
            ['false', self::TEST_PARAM_NAME, null, false],
            [1, self::TEST_PARAM_NAME, null, true],
            [0, self::TEST_PARAM_NAME, null, false],
            [true, self::TEST_PARAM_NAME, null, true],
            [false, self::TEST_PARAM_NAME, null, false],
        ];
    }
}
