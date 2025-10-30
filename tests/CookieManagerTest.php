<?php

declare(strict_types=1);

namespace MSpirkov\Yii2\Web\Tests;

use MSpirkov\Yii2\Web\CookieManager;
use PHPUnit\Framework\TestCase;
use yii\di\Instance;
use yii\web\Application;
use yii\web\Cookie;
use yii\web\Request;
use yii\web\Response;

class CookieManagerTest extends TestCase
{
    private const NON_EXISTENT_COOKIE_NAME = 'nonExistentCookieName';

    private Request $request;

    private Response $response;

    private CookieManager $cookieManager;

    protected function setUp(): void
    {
        parent::setUp();

        $projectRoot = dirname(__DIR__);

        new Application([
            'id' => 'yii2-web',
            'basePath' => $projectRoot,
            'vendorPath' => $projectRoot,
            'components' => [
                'request' => [
                    'class' => Request::class,
                    'cookieValidationKey' => uniqid(),
                ],
            ],
        ]);

        $this->request = Instance::ensure('request', Request::class);
        $this->response = Instance::ensure('response', Response::class);
        $this->cookieManager = new CookieManager($this->request, $this->response);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        restore_error_handler();
        restore_exception_handler();
    }

    public function testHasInRequest(): void
    {
        $cookie1 = new Cookie([
            'name' => 'test1',
            'value' => 'test',
            'expire' => time() + 100,
        ]);

        $cookie2 = new Cookie([
            'name' => 'test2',
            'value' => '',
            'expire' => time() + 100,
        ]);

        $cookie3 = new Cookie([
            'name' => 'test3',
            'value' => 'test',
            'expire' => time() - 100,
        ]);

        $this->request->cookies->fromArray([
            $cookie1->name => $cookie1,
            $cookie2->name => $cookie2,
            $cookie3->name => $cookie3,
        ]);

        $this->assertTrue($this->cookieManager->has($cookie1->name));
        $this->assertFalse($this->cookieManager->has($cookie2->name));
        $this->assertFalse($this->cookieManager->has($cookie3->name));
        $this->assertFalse($this->cookieManager->has(self::NON_EXISTENT_COOKIE_NAME));
    }

    public function testHas(): void
    {
        $cookieName1 = 'testHas1';
        $_COOKIE[$cookieName1] = '123';

        $cookieName2 = 'testHas2';
        $_COOKIE[$cookieName2] = '';

        $this->assertTrue($this->cookieManager->has($cookieName1, false));
        $this->assertFalse($this->cookieManager->has($cookieName2, false));
        $this->assertFalse($this->cookieManager->has('', false));
    }

    public function testGetFromRequest(): void
    {
        $cookie1 = new Cookie([
            'name' => 'test1',
            'value' => 'test',
        ]);

        $cookie2 = new Cookie([
            'name' => 'test2',
            'value' => 'test',
        ]);

        $this->request->cookies->fromArray([
            $cookie1->name => $cookie1,
            $cookie2->name => $cookie2,
        ]);

        $this->assertSameCookie($cookie1, $this->cookieManager->get($cookie1->name));
        $this->assertSameCookie($cookie2, $this->cookieManager->get($cookie2->name));
        $this->assertNull($this->cookieManager->get(self::NON_EXISTENT_COOKIE_NAME));
    }

    public function testGet(): void
    {
        $cookieName1 = 'testGet1';
        $_COOKIE[$cookieName1] = 'test';

        $expectedCookie1 = new Cookie([
            'name' => $cookieName1,
            'value' => $_COOKIE[$cookieName1],
            'expire' => null,
        ]);

        $cookieName2 = 'testGet2';
        $_COOKIE[$cookieName2] = '';

        $expectedCookie2 = new Cookie([
            'name' => $cookieName2,
            'value' => $_COOKIE[$cookieName2],
            'expire' => null,
        ]);

        $this->assertSameCookie($expectedCookie1, $this->cookieManager->get($cookieName1, false));
        $this->assertSameCookie($expectedCookie2, $this->cookieManager->get($cookieName2, false));
        $this->assertNull($this->cookieManager->get(self::NON_EXISTENT_COOKIE_NAME, false));
    }

    public function testAddByCookieData(): void
    {
        $cookieData = [
            'name' => 'test',
            'value' => 'test',
        ];

        $this->cookieManager->add($cookieData);

        $expectedCookie = new Cookie($cookieData);

        $this->assertSame(1, $this->response->cookies->count);
        $this->assertSameCookie($expectedCookie, $this->response->cookies->get($cookieData['name']));
    }

    public function testAddByCookieObject(): void
    {
        $cookie = new Cookie([
            'name' => 'test',
            'value' => 'test',
        ]);

        $this->cookieManager->add($cookie);

        $this->assertSame(1, $this->response->cookies->count);
        $this->assertSameCookie($cookie, $this->response->cookies->get($cookie->name));
    }

    public function testRemoveFromBrowserByObject(): void
    {
        $cookie = new Cookie([
            'name' => 'test',
            'value' => 'test',
            'expire' => time() + 100,
        ]);

        $this->response->cookies->add($cookie);

        $this->cookieManager->remove($cookie);

        $expectedCookie = new Cookie([
            'name' => $cookie->name,
            'value' => '',
            'expire' => 1,
        ]);

        $this->assertSame(1, $this->response->cookies->count);
        $this->assertSameCookie($expectedCookie, $this->response->cookies->get($cookie->name));
    }

    public function testRemoveFromBrowserByName(): void
    {
        $cookie = new Cookie([
            'name' => 'test',
            'value' => 'test',
            'expire' => time() + 100,
        ]);

        $this->response->cookies->add($cookie);

        $this->cookieManager->remove($cookie->name);

        $expectedCookie = new Cookie([
            'name' => $cookie->name,
            'value' => '',
            'expire' => 1,
        ]);

        $this->assertSame(1, $this->response->cookies->count);
        $this->assertSameCookie($expectedCookie, $this->response->cookies->get($cookie->name));
    }

    public function testRemoveByObject(): void
    {
        $cookie = new Cookie([
            'name' => 'test',
            'value' => 'test',
            'expire' => time() + 100,
        ]);

        $this->response->cookies->add($cookie);

        $this->cookieManager->remove($cookie, false);
        $this->assertSame(0, $this->response->cookies->count);
    }

    public function testRemoveByName(): void
    {
        $cookie1 = new Cookie([
            'name' => 'test1',
            'value' => 'test',
            'expire' => time() + 100,
        ]);

        $cookie2 = new Cookie([
            'name' => 'test2',
            'value' => 'test',
            'expire' => time() + 100,
        ]);

        $this->response->cookies->add($cookie1);
        $this->response->cookies->add($cookie2);

        $this->cookieManager->remove($cookie1->name, false);

        $this->assertSame(1, $this->response->cookies->count);
        $this->assertSameCookie($cookie2, $this->response->cookies->get($cookie2->name));
    }

    public function testRemoveAll(): void
    {
        $cookie1 = new Cookie([
            'name' => 'test1',
            'value' => 'test1',
            'expire' => time() + 100,
        ]);

        $cookie2 = new Cookie([
            'name' => 'test2',
            'value' => 'test2',
            'expire' => time() + 100,
        ]);

        $this->response->cookies->add($cookie1);
        $this->response->cookies->add($cookie2);

        $this->cookieManager->removeAll();
        $this->assertSame(0, $this->response->cookies->count);
    }

    private function assertSameCookie(Cookie $expectedCookie, ?Cookie $cookie): void
    {
        $this->assertNotNull($cookie);
        $this->assertSame($expectedCookie->domain, $cookie->domain);
        $this->assertSame($expectedCookie->expire, $cookie->expire);
        $this->assertSame($expectedCookie->httpOnly, $cookie->httpOnly);
        $this->assertSame($expectedCookie->name, $cookie->name);
        $this->assertSame($expectedCookie->path, $cookie->path);
        $this->assertSame($expectedCookie->sameSite, $cookie->sameSite);
        $this->assertSame($expectedCookie->secure, $cookie->secure);
        $this->assertSame($expectedCookie->value, $cookie->value);
    }
}
