<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use yii\web\BadRequestHttpException;

/**
 * A wrapper for {@link \yii\web\Request} for easier handling of GET and POST parameters.
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 */
class Request extends \yii\web\Request
{
    /**
     * Gets the value of a GET parameter by its name and tries to convert it to an integer.
     *
     * @template T of int|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default value of a parameter if the parameter does not
     * exist or is an empty string.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return int|T Сonverted value or default value
     */
    public function getGetInt(string $name, ?int $defaultValue = null): ?int
    {
        /** @var int|T */
        return $this->filterScalarValue(
            $name,
            $this->get($name),
            $defaultValue,
            FILTER_VALIDATE_INT,
            true
        );
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
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return float|T Сonverted value or default value
     */
    public function getGetFloat(string $name, ?float $defaultValue = null): ?float
    {
        /** @var float|T */
        return $this->filterScalarValue(
            $name,
            $this->get($name),
            $defaultValue,
            FILTER_VALIDATE_FLOAT,
            true
        );
    }

    /**
     * Gets the value of the GET parameter by its name and tries to convert it to a boolean.
     *
     * @template T of bool|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default value of a parameter if the parameter does not
     * exist or is an empty string.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return bool|T Сonverted value or default value
     */
    public function getGetBool(string $name, ?bool $defaultValue = null): ?bool
    {
        /** @var bool|T */
        return $this->filterScalarValue(
            $name,
            $this->get($name),
            $defaultValue,
            FILTER_VALIDATE_BOOLEAN,
            true
        );
    }

    /**
     * Gets the value of the GET parameter by its name and tries to convert it to a string.
     *
     * @template T of string|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return string|T Сonverted value or default value
     */
    public function getGetString(string $name, ?string $defaultValue = null): ?string
    {
        $value = $this->get($name);
        if ($value === null) {
            return $defaultValue;
        }

        if (!is_scalar($value)) {
            $this->throwBadRequestException($name);
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
     *
     * @return array<array-key, mixed>|T Сonverted value or default value
     */
    public function getGetArray(string $name, ?array $defaultValue = null): ?array
    {
        $value = $this->get($name);

        return $value !== null ? (array) $value : $defaultValue;
    }

    /**
     * Gets the value of a POST parameter by its name and tries to convert it to an integer.
     *
     * @template T of int|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return int|T Сonverted value or default value
     */
    public function getPostInt(string $name, ?int $defaultValue = null): ?int
    {
        /** @var int|T */
        return $this->filterScalarValue(
            $name,
            $this->post($name),
            $defaultValue,
            FILTER_VALIDATE_INT,
            false
        );
    }

    /**
     * Gets the value of the POST parameter by its name and tries to convert it to a
     * floating-point number.
     *
     * @template T of float|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return float|T Сonverted value or default value
     */
    public function getPostFloat(string $name, ?float $defaultValue = null): ?float
    {
        /** @var float|T */
        return $this->filterScalarValue(
            $name,
            $this->post($name),
            $defaultValue,
            FILTER_VALIDATE_FLOAT,
            false
        );
    }

    /**
     * Gets the value of the POST parameter by its name and tries to convert it to a boolean.
     *
     * @template T of bool|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return bool|T Сonverted value or default value
     */
    public function getPostBool(string $name, ?bool $defaultValue = null): ?bool
    {
        /** @var bool|T */
        return $this->filterScalarValue(
            $name,
            $this->post($name),
            $defaultValue,
            FILTER_VALIDATE_BOOLEAN,
            false
        );
    }

    /**
     * Gets the value of the POST parameter by its name and tries to convert it to a string.
     *
     * @template T of string|null
     *
     * @param string $name The parameter name.
     * @param T $defaultValue The default parameter value if the parameter does not exist.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return string|T Сonverted value or default value
     */
    public function getPostString(string $name, ?string $defaultValue = null): ?string
    {
        $value = $this->post($name);
        if ($value === null) {
            return $defaultValue;
        }

        if (!is_scalar($value)) {
            $this->throwBadRequestException($name);
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
     *
     * @throws BadRequestHttpException If the value is not an array.
     *
     * @return array<array-key, mixed>|T Value, if exists, or default value.
     */
    public function getPostArray(string $name, ?array $defaultValue = null): ?array
    {
        $value = $this->post($name);
        if ($value === null) {
            return $defaultValue;
        }

        if (!is_array($value)) {
            $this->throwBadRequestException($name);
        }

        return $value;
    }

    /**
     * Attempts to convert the specified value to the specified type.
     *
     * @param mixed $value The original value of the parameter.
     * @param int|float|bool|null $defaultValue The default parameter value.
     * @param int<FILTER_VALIDATE_INT, FILTER_VALIDATE_FLOAT> $filter The ID of the filter to apply.
     *
     * @throws BadRequestHttpException If the value cannot be converted.
     *
     * @return int|float|bool|null Сonverted value or default value
     *
     * @see https://www.php.net/manual/ru/function.filter-var.php
     */
    private function filterScalarValue(
        string $name,
        $value,
        $defaultValue,
        int $filter,
        bool $isGetParam
    ) {
        if ($value === null || ($isGetParam && $value === '')) {
            return $defaultValue;
        }

        /** @var int|float|bool|null */
        $filteredValue = filter_var($value, $filter, FILTER_NULL_ON_FAILURE);
        if ($filteredValue === null) {
            $this->throwBadRequestException($name);
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
    private function throwBadRequestException(string $name): void
    {
        throw new BadRequestHttpException("Invalid value for parameter: {$name}");
    }
}
