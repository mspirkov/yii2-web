<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use yii\web\Request as BaseRequest;

/**
 * A wrapper for {@see BaseRequest}.
 *
 * It contains the following methods:
 *
 * - {@see TypedRequestParametersTrait::getGetInt()} - gets the value of a **GET** parameter by its name and tries to
 *   convert it to an integer.
 * - {@see TypedRequestParametersTrait::getGetFloat()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a floating-point number.
 * - {@see TypedRequestParametersTrait::getGetBool()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a boolean.
 * - {@see TypedRequestParametersTrait::getGetString()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a string.
 * - {@see TypedRequestParametersTrait::getGetArray()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to an array.
 * - {@see TypedRequestParametersTrait::getPostInt()} - gets the value of a **POST** parameter by its name and tries to
 *   convert it to an integer.
 * - {@see TypedRequestParametersTrait::getPostFloat()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a floating-point number.
 * - {@see TypedRequestParametersTrait::getPostBool()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a boolean.
 * - {@see TypedRequestParametersTrait::getPostString()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a string.
 * - {@see TypedRequestParametersTrait::getPostArray()} - gets the value of the **POST** parameter by its name and checks that
 *   the value is an array.
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 */
class Request extends BaseRequest
{
    use TypedRequestParametersTrait;
}
