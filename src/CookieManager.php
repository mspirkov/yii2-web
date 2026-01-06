<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use DateTimeInterface;
use yii\web\Response;
use yii\web\Cookie;
use yii\web\Request;

/**
 * A utility class for managing cookies.
 *
 * This class encapsulates the logic for adding, removing, checking existence, and
 * retrieving cookies, using the {@see \yii\web\Request} and {@see \yii\web\Response}
 * objects. It simplifies working with cookies by abstracting implementation details
 * and providing more convenient methods.
 *
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
 *
 * @immutable
 */
class CookieManager
{
    private Request $request;

    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

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
    public function has(string $name, bool $inRequest = true): bool
    {
        if ($inRequest) {
            return $this->request->cookies->has($name);
        }

        $cookieValue = $_COOKIE[$name] ?? null;

        return $cookieValue !== null && $cookieValue !== '';
    }

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
    public function get(string $name, bool $fromRequest = true): ?Cookie
    {
        return $fromRequest ? $this->request->cookies->get($name) : $this->getDirectly($name);
    }

    /**
     * Adds a cookie to the response.
     *
     * If there is already a cookie with the same name in the collection, it will be removed first.
     *
     * @param Cookie|CookieData $data The cookie to be added. It can be a `Cookie` object
     * or a `CookieData` array.
     */
    public function add($data): void
    {
        $cookie = is_array($data) ? new Cookie($data) : $data;

        $this->response->cookies->add($cookie);
    }

    /**
     * Removes a cookie.
     *
     * If `$removeFromBrowser` is `true`, the cookie will be removed from the browser.
     * In this case, a cookie with outdated expiry will be added to the collection.
     *
     * @param Cookie|string $cookie The cookie object or the name of the cookie to be removed.
     * @param bool $removeFromBrowser Whether to remove the cookie from browser.
     */
    public function remove($cookie, bool $removeFromBrowser = true): void
    {
        $this->response->cookies->remove($cookie, $removeFromBrowser);
    }

    /**
     * Removes all cookies.
     */
    public function removeAll(): void
    {
        $this->response->cookies->removeAll();
    }

    /**
     * Retrieves a Cookie directly from the `$_COOKIE` superglobal array.
     *
     * @param string $name The name of the cookie to retrieve.
     *
     * @return Cookie|null The cookie with the specified name. Null if the named cookie does
     * not exist.
     */
    private function getDirectly(string $name): ?Cookie
    {
        $value = $_COOKIE[$name] ?? null;
        if ($value === null) {
            return null;
        }

        return new Cookie([
            'name' => $name,
            'value' => $value,
            'expire' => null,
        ]);
    }
}
