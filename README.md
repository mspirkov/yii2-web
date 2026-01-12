<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 WEB Extension</h1>
</p>

A package of helper classes for working with web components in Yii2.

[![PHP](https://img.shields.io/badge/%3E%3D7.4-7A86B8.svg?style=for-the-badge&logo=php&logoColor=white&label=PHP)](https://www.php.net/releases/7_4_0.php)
[![Yii 2.0.x](https://img.shields.io/badge/%3E%3D2.0.53-247BA0.svg?style=for-the-badge&logo=yii&logoColor=white&label=Yii)](https://github.com/yiisoft/yii2/tree/2.0.53)
[![Tests](https://img.shields.io/github/actions/workflow/status/mspirkov/yii2-web/ci.yml?branch=main&style=for-the-badge&logo=github&label=Tests)](https://github.com/mspirkov/yii2-web/actions/workflows/ci.yml)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/mspirkov/yii2-web/ci.yml?branch=main&style=for-the-badge&logo=github&label=PHPStan)](https://github.com/mspirkov/yii2-web/actions/workflows/ci.yml)
![Coverage](https://img.shields.io/badge/100%25-44CC11.svg?style=for-the-badge&label=Coverage)
![PHPStan Level Max](https://img.shields.io/badge/Max-7A86B8.svg?style=for-the-badge&label=PHPStan%20Level)

## Installation

Run

```bash
php composer.phar require mspirkov/yii2-web
```

or add

```json
"mspirkov/yii2-web": "^0.1"
```

to the `require` section of your `composer.json` file.

## Components

- [Request](#request)
- [CookieManager](#cookiemanager)

### Request

A wrapper for `\yii\web\Request` for easier handling of **GET** and **POST** parameters.

It contains the following methods:

- `getGetInt` - gets the value of a **GET** parameter by its name and tries to convert it to an integer.
- `getGetFloat` - gets the value of the **GET** parameter by its name and tries to convert it to a floating-point number.
- `getGetBool` - gets the value of the **GET** parameter by its name and tries to convert it to a boolean.
- `getGetString` - gets the value of the **GET** parameter by its name and tries to convert it to a string.
- `getGetArray` - gets the value of the **GET** parameter by its name and tries to convert it to an array.
- `getPostInt` - gets the value of a **POST** parameter by its name and tries to convert it to an integer.
- `getPostFloat` - gets the value of the **POST** parameter by its name and tries to convert it to a floating-point number.
- `getPostBool` - gets the value of the **POST** parameter by its name and tries to convert it to a boolean.
- `getPostString` - gets the value of the **POST** parameter by its name and tries to convert it to a string.
- `getPostArray` - gets the value of the **POST** parameter by its name and checks that the value is an array.

#### Configuration

First, you need to replace the `request` component in the configuration:

```php
use MSpirkov\Yii2\Web\Request;

return [
    ...
    'components' => [
        'request' => [
            'class' => Request::class,
            ...
        ],
        ...
    ],
];
```

#### IDE Autocomplete (Optional)

You also need to specify this class in `__autocomplete.php` so that the IDE knows which class to use:

```php
<?php

use yii\BaseYii;
use yii\web\Application;
use MSpirkov\Yii2\Web\Request;

class Yii extends BaseYii
{
    /** @var __Application */
    public static $app;
}

/**
 * @property-read Request $request
 */
class __Application extends Application {}
```

#### Basic Controller (Optional)

I also recommend that you create your own basic controller and specify `Request` there:

```php
use MSpirkov\Yii2\Web\Request;

/**
 * @property Request $request
 */
class Controller extends \yii\web\Controller
{
    public function init(): void
    {
        parent::init();

        $this->request = Instance::ensure($this->request, Request::class);
    }
}
```

#### Usage example:

```php
class ProductController extends Controller
{
    public function __construct(
        string $id,
        Module $module,
        private readonly ProductService $service,
        array $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionDelete(): array
    {
        $this->response->format = Response::FORMAT_JSON;

        return $this->service->delete($this->request->getPostInt('id'));
    }
}
```

### CookieManager

A utility class for managing cookies.

This class encapsulates the logic for adding, removing, checking existence, and retrieving cookies, using the `\yii\web\Request`
and `\yii\web\Response` objects. It simplifies working with cookies by abstracting implementation details and providing more
convenient methods.

It contains the following methods:

- `has` - checks if a cookie with the specified name exists.
- `get` - returns the cookie with the specified name.
- `add` - adds a cookie to the response.
- `remove` - removes a cookie.
- `removeAll` - removes all cookies.

#### Usage example:

```php
class CookieManager extends \MSpirkov\Yii2\Web\CookieManager
{
    public function __construct()
    {
        parent::__construct(
            Instance::ensure('request', Request::class),
            Instance::ensure('response', Response::class),
        );
    }
}
```

```php
class ExampleService
{
    public function __construct(
        private readonly CookieManager $cookieManager,
    ) {}

    public function addCookie(): void
    {
        $this->cookieManager->add([
            'name' => 'someCookieName',
            'value' => 'someCookieValue',
        ]);
    }
}
```
