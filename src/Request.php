<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use yii\web\BadRequestHttpException;
use yii\web\Request as BaseRequest;

/**
 * A wrapper for {@see BaseRequest} for easier handling of GET and POST parameters.
 *
 * It contains the following methods:
 *
 * - {@see Request::getGetInt()} - gets the value of a **GET** parameter by its name and tries to
 *   convert it to an integer.
 * - {@see Request::getGetFloat()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a floating-point number.
 * - {@see Request::getGetBool()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a boolean.
 * - {@see Request::getGetString()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to a string.
 * - {@see Request::getGetArray()} - gets the value of the **GET** parameter by its name and tries to
 *   convert it to an array.
 * - {@see Request::getPostInt()} - gets the value of a **POST** parameter by its name and tries to
 *   convert it to an integer.
 * - {@see Request::getPostFloat()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a floating-point number.
 * - {@see Request::getPostBool()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a boolean.
 * - {@see Request::getPostString()} - gets the value of the **POST** parameter by its name and tries to
 *   convert it to a string.
 * - {@see Request::getPostArray()} - gets the value of the **POST** parameter by its name and checks that
 *   the value is an array.
 *
 * To use it, you need to replace the `request` component in the configuration:
 *
 * ```
 * use MSpirkov\Yii2\Web\Request;
 *
 * return [
 *     ...
 *     'components' => [
 *         'request' => [
 *             'class' => Request::class,
 *             ...
 *         ],
 *         ...
 *     ],
 * ];
 * ```
 *
 * Usage example:
 *
 * ```
 * use yii\web\Controller;
 *
 * class ProductController extends Controller
 * {
 *     public function actionDelete(): array
 *     {
 *         $id = $this->request->getPostInt('id');
 *
 *         // There's some logic here. For example, calling a service class method to delete
 *         // a product with the parameter `$id`.
 *     }
 * }
 * ```
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 */
class Request extends BaseRequest
{
    /**
     * Gets the value of a GET parameter by its name and tries to convert it to an integer.
     *
     * @template T of int|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default value of a parameter if the parameter does not
     * exist or is an empty string.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist or is an empty string, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist or is an empty string.
     *
     * @return ($required is true ? int : int|T) Сonverted value or default value.
     */
    public function getGetInt(string $name, ?int $defaultValue = null, bool $required = false): ?int
    {
        $value = $this->get($name);
        if ($value === null || $value === '') {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return $this->filterScalarValue($name, $value, FILTER_VALIDATE_INT);
    }

    /**
     * Gets the value of the GET parameter by its name and tries to convert it to a
     * floating-point number.
     *
     * @template T of float|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default value of a parameter if the parameter does not
     * exist or is an empty string.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist or is an empty string, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist or is an empty string.
     *
     * @return ($required is true ? float : float|T) Сonverted value or default value.
     */
    public function getGetFloat(string $name, ?float $defaultValue = null, bool $required = false): ?float
    {
        $value = $this->get($name);
        if ($value === null || $value === '') {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return $this->filterScalarValue($name, $value, FILTER_VALIDATE_FLOAT);
    }

    /**
     * Gets the value of the GET parameter by its name and tries to convert it to a boolean.
     *
     * @template T of bool|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default value of a parameter if the parameter does not
     * exist or is an empty string.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist or is an empty string, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist or is an empty string.
     *
     * @return ($required is true ? bool : bool|T) Сonverted value or default value.
     */
    public function getGetBool(string $name, ?bool $defaultValue = null, bool $required = false): ?bool
    {
        $value = $this->get($name);
        if ($value === null || $value === '') {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return $this->filterScalarValue($name, $value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Gets the value of the GET parameter by its name and tries to convert it to a string.
     *
     * @template T of string|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist.
     *
     * @return ($required is true ? string : string|T) Сonverted value or default value.
     */
    public function getGetString(string $name, ?string $defaultValue = null, bool $required = false): ?string
    {
        $value = $this->get($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        if (!is_scalar($value)) {
            $this->throwInvalidParamException($name);
        }

        return (string) $value;
    }

    /**
     * Gets the value of the GET parameter by its name and tries to convert it to an array.
     *
     * @template T of array<array-key, mixed>|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the parameter is required and does not exist.
     *
     * @return ($required is true ? array<array-key, mixed> : array<array-key, mixed>|T) Сonverted value
     * or default value.
     */
    public function getGetArray(string $name, ?array $defaultValue = null, bool $required = false): ?array
    {
        $value = $this->get($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return (array) $value;
    }

    /**
     * Gets the value of a POST parameter by its name and tries to convert it to an integer.
     *
     * @template T of int|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist.
     *
     * @return ($required is true ? int : int|T) Сonverted value or default value.
     */
    public function getPostInt(string $name, ?int $defaultValue = null, bool $required = false): ?int
    {
        $value = $this->post($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return $this->filterScalarValue($name, $value, FILTER_VALIDATE_INT);
    }

    /**
     * Gets the value of the POST parameter by its name and tries to convert it to a
     * floating-point number.
     *
     * @template T of float|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist.
     *
     * @return ($required is true ? float : float|T) Сonverted value or default value.
     */
    public function getPostFloat(string $name, ?float $defaultValue = null, bool $required = false): ?float
    {
        $value = $this->post($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return $this->filterScalarValue($name, $value, FILTER_VALIDATE_FLOAT);
    }

    /**
     * Gets the value of the POST parameter by its name and tries to convert it to a boolean.
     *
     * @template T of bool|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist.
     *
     * @return ($required is true ? bool : bool|T) Сonverted value or default value.
     */
    public function getPostBool(string $name, ?bool $defaultValue = null, bool $required = false): ?bool
    {
        $value = $this->post($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        return $this->filterScalarValue($name, $value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Gets the value of the POST parameter by its name and tries to convert it to a string.
     *
     * @template T of string|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the value cannot be converted. Also, if the parameter
     * is required and does not exist.
     *
     * @return ($required is true ? string : string|T) Сonverted value or default value.
     */
    public function getPostString(string $name, ?string $defaultValue = null, bool $required = false): ?string
    {
        $value = $this->post($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        if (!is_scalar($value)) {
            $this->throwInvalidParamException($name);
        }

        return (string) $value;
    }

    /**
     * Gets the value of the POST parameter by its name and checks that the value is an array.
     *
     * @template T of array<array-key, mixed>|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     * @param bool $required Whether the argument is required. If `true` and the parameter does
     * not exist, an exception will be thrown.
     *
     * @throws BadRequestHttpException If the parameter is required and does not exist.
     *
     * @return ($required is true ? array<array-key, mixed> : array<array-key, mixed>|T) Сonverted value
     * or default value.
     */
    public function getPostArray(string $name, ?array $defaultValue = null, bool $required = false): ?array
    {
        $value = $this->post($name);
        if ($value === null) {
            if ($required) {
                $this->throwMissingParamException($name);
            }

            return $defaultValue;
        }

        if (!is_array($value)) {
            $this->throwInvalidParamException($name);
        }

        return $value;
    }

    /**
     * Attempts to convert the specified value to the specified type.
     *
     * @param mixed $value The original value of the parameter.
     * @param int<FILTER_VALIDATE_INT, FILTER_VALIDATE_FLOAT> $filter The ID of the filter to apply.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return ($filter is FILTER_VALIDATE_INT ? int : ($filter is FILTER_VALIDATE_FLOAT ? float : bool)) Сonverted
     * value or default value.
     *
     * @link https://www.php.net/manual/ru/function.filter-var.php
     */
    private function filterScalarValue(string $name, $value, int $filter)
    {
        /** @var int|float|bool|null */
        $filteredValue = filter_var($value, $filter, FILTER_NULL_ON_FAILURE);
        if ($filteredValue === null) {
            $this->throwInvalidParamException($name);
        }

        return $filteredValue;
    }

    /**
     * @param string $name The parameter name.
     *
     * @throws BadRequestHttpException
     *
     * @return never
     */
    private function throwMissingParamException(string $name): void
    {
        throw new BadRequestHttpException("Missing required parameter: {$name}");
    }

    /**
     * @param string $name The parameter name.
     *
     * @throws BadRequestHttpException
     *
     * @return never
     */
    private function throwInvalidParamException(string $name): void
    {
        throw new BadRequestHttpException("Invalid value for parameter: {$name}");
    }
}
