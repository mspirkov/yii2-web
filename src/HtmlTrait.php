<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use yii\helpers\Html;

/**
 * A trait that extends the basic functionality of the {@see Html} helper.
 *
 * It contains the following methods:
 *
 * - {@see HtmlTrait::singleButtonForm()} - сreates a form as a single button with hidden inputs.
 *
 * Usage example:
 *
 * ```
 * use MSpirkov\Yii2\Web\HtmlTrait;
 *
 * class Html extends \yii\helpers\Html
 * {
 *     use HtmlTrait;
 * }
 * ```
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 *
 * @phpstan-require-extends Html
 */
trait HtmlTrait
{
    /**
     * Сreates a form as a single button with hidden inputs.
     *
     * This can be useful when you need to perform an action when you click a button, such as
     * deleting an item. This allows you to easily perform a request without manually creating
     * a form, hidden inputs, etc.
     *
     * Usage example:
     *
     * ```
     * <?= Html::singleButtonForm(['product/delete'], ['id' => $product->id], 'Delete'); ?>
     * ```
     *
     * @param string|array<array-key, mixed> $action The form action URL. For more information
     * see {@see Html::beginForm()}.
     * @param array<string, string|null> $data Data in terms of name-value pairs. These data are sent
     * to the specified `$action` when the button is clicked.
     * @param string $buttonContent The content enclosed within the button tag. For more information
     * see {@see Html::submitButton()}.
     * @param array<string, mixed> $buttonOptions The tag options in terms of name-value pairs. These will
     * be rendered as the attributes of the resulting tag. For more information see {@see Html::submitButton()}.
     * @param string $formMethod The form submission method, such as "post", "get", "put", "delete"
     * (case-insensitive). For more information see {@see Html::beginForm()}.
     * @param array<string, mixed> $formOptions The tag options in terms of name-value pairs. These will
     * be rendered as the attributes of the resulting tag. For more information see {@see Html::beginForm()}.
     */
    public static function singleButtonForm(
        $action,
        array $data,
        string $buttonContent,
        array $buttonOptions = [],
        string $formMethod = 'post',
        array $formOptions = []
    ): string {
        $content = static::beginForm($action, $formMethod, $formOptions);

        foreach ($data as $key => $val) {
            $content .= static::hiddenInput($key, $val);
        }

        $content .= static::submitButton($buttonContent, $buttonOptions);

        return $content . static::endForm();
    }
}
