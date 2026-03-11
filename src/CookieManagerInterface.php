<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use DateTimeInterface;
use yii\web\Cookie;

/**
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 *
 * @phpstan-type CookieData array{
 *     name: string,
 *     value: string,
 *     expire?: int|string|DateTimeInterface|null,
 *     path?: string,
 *     domain?: string,
 *     secure?: bool,
 *     httpOnly?: bool,
 *     sameSite?: string,
 * }
 */
interface CookieManagerInterface
{
    /**
     * Checks if a cookie with the specified name exists.
     *
     * The cookie can be checked in the Request object (normal behavior) or directly in
     * the `$_COOKIE` superglobal array.
     *
     * Note that if a cookie is marked for deletion from browser or its value is an empty
     * string, this method will return `false`.
     *
     * @param string $name The name of the cookie to check.
     * @param bool $inRequest Determines whether to look for the cookie in the Request
     * object or directly in `$_COOKIE`.
     *
     * @return bool Whether the named cookie exists.
     */
    public function has(string $name, bool $inRequest = true): bool;

    /**
     * Returns the cookie with the specified name.
     *
     * The cookie can be retrieved from the Request object (normal behavior) or directly
     * from the `$_COOKIE` superglobal array.
     *
     * @param string $name The name of the cookie to retrieve.
     * @param bool $fromRequest Determines whether to retrieve the cookie from the Request
     * object or directly from `$_COOKIE`.
     *
     * @return Cookie|null The cookie with the specified name. Null if the named cookie does
     * not exist.
     */
    public function get(string $name, bool $fromRequest = true): ?Cookie;

    /**
     * Adds a cookie to the response.
     *
     * If there is already a cookie with the same name in the collection, it will be removed first.
     *
     * @param Cookie|CookieData $data The cookie to be added. It can be a `Cookie` object
     * or a `CookieData` array.
     */
    public function add($data): void;

    /**
     * Removes a cookie.
     *
     * If `$removeFromBrowser` is `true`, the cookie will be removed from the browser.
     * In this case, a cookie with outdated expiry will be added to the collection.
     *
     * @param Cookie|string $cookie The cookie object or the name of the cookie to be removed.
     * @param bool $removeFromBrowser Whether to remove the cookie from browser.
     */
    public function remove($cookie, bool $removeFromBrowser = true): void;

    /**
     * Removes all cookies.
     */
    public function removeAll(): void;
}
