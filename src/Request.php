<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use yii\web\Request as BaseRequest;

/**
 * A wrapper for {@see BaseRequest}.
 *
 * It contains the following methods:
 *
 * - {@see RequestTrait::getGetInt()} - gets the value of a **GET** parameter by its name and tries to
 *   convert it to an integer.
 * - {@see RequestTrait::getGetFloat()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a floating-point number.
 * - {@see RequestTrait::getGetBool()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a boolean.
 * - {@see RequestTrait::getGetString()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a string.
 * - {@see RequestTrait::getGetArray()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to an array.
 * - {@see RequestTrait::getPostInt()} - gets the value of a **POST** parameter by its name and tries to
 *   convert it to an integer.
 * - {@see RequestTrait::getPostFloat()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a floating-point number.
 * - {@see RequestTrait::getPostBool()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a boolean.
 * - {@see RequestTrait::getPostString()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a string.
 * - {@see RequestTrait::getPostArray()} - gets the value of the **POST** parameter by its name and checks that
 *   the value is an array.
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 */
class Request extends BaseRequest
{
    use RequestTrait;
}
