<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web;

use yii\web\Response;
use yii\web\Cookie;
use yii\web\Request;

/**
 * A utility class for managing cookies.
 *
 * This class encapsulates the logic for adding, removing, checking existence, and retrieving cookies,
 * using the {@see Request} and {@see Response} objects. It simplifies working with cookies by
 * abstracting implementation details and providing more convenient methods.
 *
 * It contains the following methods:
 *
 * - {@see CookieManagerInterface::has()} - checks if a cookie with the specified name exists.
 * - {@see CookieManagerInterface::get()} - returns the cookie with the specified name.
 * - {@see CookieManagerInterface::add()} - adds a cookie to the response.
 * - {@see CookieManagerInterface::remove()} - removes a cookie.
 * - {@see CookieManagerInterface::removeAll()} - removes all cookies.
 *
 * @author Maksim Spirkov <spirkov.2001@mail.ru>
 *
 * @immutable
 */
final class CookieManager implements CookieManagerInterface
{
    private Request $request;

    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function has(string $name, bool $inRequest = true): bool
    {
        if ($inRequest) {
            return $this->request->cookies->has($name);
        }

        $cookieValue = $_COOKIE[$name] ?? null;

        return $cookieValue !== null && $cookieValue !== '';
    }

    public function get(string $name, bool $fromRequest = true): ?Cookie
    {
        return $fromRequest ? $this->request->cookies->get($name) : $this->getDirectly($name);
    }

    public function add($data): void
    {
        $cookie = is_array($data) ? new Cookie($data) : $data;

        $this->response->cookies->add($cookie);
    }

    public function remove($cookie, bool $removeFromBrowser = true): void
    {
        $this->response->cookies->remove($cookie, $removeFromBrowser);
    }

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
