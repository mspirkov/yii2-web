<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Bootstrap5;

use MSpirkov\Yii2\Web\HtmlTrait;
use yii\bootstrap5\Html as BaseHtml;

/**
 * A wrapper for {@see BaseHtml}.
 *
 * It contains the following methods:
 *
 * - {@see HtmlTrait::singleButtonForm()} - сreates a form as a single button with hidden inputs.
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 */
final class Html extends BaseHtml
{
    use HtmlTrait;
}
