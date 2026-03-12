<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests;

use yii\base\Module;
use yii\web\Controller;

/**
 * @extends Controller<Module>
 */
final class TestController extends Controller
{
    public function actionRun(): void {}
}
