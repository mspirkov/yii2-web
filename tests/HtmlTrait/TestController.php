<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests\HtmlTrait;

use yii\base\Module;
use yii\web\Controller;

/**
 * @extends Controller<Module>
 */
class TestController extends Controller
{
    public function actionRun(): void {}
}
