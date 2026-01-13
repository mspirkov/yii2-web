<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests\HtmlTrait;

use MSpirkov\Yii2\Web\Tests\AbstractTestCase;
use Yii;
use yii\base\Module;

class HtmlTraitTest extends AbstractTestCase
{
    private const TEST_ACTION = 'https://test.com';

    /**
     * @dataProvider provideSingleButtonFormData
     *
     * @param array<string, string|null> $data
     * @param array<string, mixed> $buttonOptions
     * @param array<string, mixed> $formOptions
     */
    public function testSingleButtonForm(
        string $action,
        array $data,
        string $buttonContent,
        array $buttonOptions,
        string $formMethod,
        array $formOptions,
        string $expectedResult
    ): void {
        $content = Html::singleButtonForm(
            $action,
            $data,
            $buttonContent,
            $buttonOptions,
            $formMethod,
            $formOptions
        );

        $this->assertSameHtmlContent($expectedResult, $content);
    }

    /**
     * @return list<array{
     *     string,
     *     array<string, string|null>,
     *     string,
     *     array<string, mixed>,
     *     string,
     *     array<string, mixed>,
     *     string,
     * }>
     */
    public static function provideSingleButtonFormData(): array
    {
        return [
            [
                self::TEST_ACTION,
                ['test' => '123', 'testTest' => '456'],
                'Go',
                [],
                'post',
                [],
                <<<HTML
                    <form action="https://test.com" method="post">
                        <input type="hidden" name="test" value="123">
                        <input type="hidden" name="testTest" value="456">
                        <button type="submit">Go</button>
                    </form>
                    HTML,
            ],
            [
                self::TEST_ACTION,
                ['test' => '123', 'testTest' => '456'],
                'Go',
                [],
                'GET',
                [],
                <<<HTML
                    <form action="https://test.com" method="GET">
                        <input type="hidden" name="test" value="123">
                        <input type="hidden" name="testTest" value="456">
                        <button type="submit">Go</button>
                    </form>
                    HTML,
            ],
            [
                self::TEST_ACTION,
                ['test' => '123', 'testTest' => '456'],
                'RUN',
                [
                    'id' => 'btn-id',
                    'class' => 'btn btn-danger',
                ],
                'POST',
                [],
                <<<HTML
                    <form action="https://test.com" method="POST">
                        <input type="hidden" name="test" value="123">
                        <input type="hidden" name="testTest" value="456">
                        <button type="submit" id="btn-id" class="btn btn-danger">RUN</button>
                    </form>
                    HTML,
            ],
            [
                self::TEST_ACTION,
                ['test' => '123', 'testTest' => '456'],
                'RUN',
                [
                    'id' => 'btn-id',
                    'class' => 'btn btn-danger',
                ],
                'POST',
                [
                    'id' => 'form-id',
                ],
                <<<HTML
                    <form id="form-id" action="https://test.com" method="POST">
                        <input type="hidden" name="test" value="123">
                        <input type="hidden" name="testTest" value="456">
                        <button type="submit" id="btn-id" class="btn btn-danger">RUN</button>
                    </form>
                    HTML,
            ],
        ];
    }

    public function testSingleButtonFormWithMinParams(): void
    {
        $content = Html::singleButtonForm(self::TEST_ACTION, ['test' => '123', 'testTest' => '456'], 'Go');

        $this->assertSameHtmlContent(
            <<<HTML
                <form action="https://test.com" method="post">
                    <input type="hidden" name="test" value="123">
                    <input type="hidden" name="testTest" value="456">
                    <button type="submit">Go</button>
                </form>
                HTML,
            $content
        );
    }

    public function testSingleButtonFormWithArrayAction(): void
    {
        Yii::$app->controller = new TestController('test', new Module('module'));

        $content = Html::singleButtonForm(['test/run'], ['test' => '123', 'testTest' => '456'], 'Go');

        $this->assertSameHtmlContent(
            <<<HTML
                <form action="https://yii2-web.com/module/test/run" method="post">
                    <input type="hidden" name="test" value="123">
                    <input type="hidden" name="testTest" value="456">
                    <button type="submit">Go</button>
                </form>
                HTML,
            $content
        );
    }

    private function assertSameHtmlContent(string $expected, string $actual): void
    {
        self::assertSame(str_replace(['    ', "\n"], '', $expected), $actual);
    }
}
