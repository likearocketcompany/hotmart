# Hotmart API - PHP Client

A PHP wrapper for the Hotmart REST API. Easily interact with the Hotmart REST API securely using this library.


## Installation

```
composer require like-a-rocket/hotmart
```


## Getting started

Generate API credentials (Access Token) following this instructions <https://developers.hotmart.com/docs/pt-BR/start/app-auth/>.
Check out the Hotmart API endpoints and data that can be manipulated in <https://developers.hotmart.com/docs/pt-BR/>.


## Client class

```php
$hotmart = new Client('https://sandbox.hotmart.com', 'wxyz');
```

## Client methods

### GET

```php
$hotmart->get($endpoint, $parameters = []);
```

### POST

```php
$hotmart->post($endpoint, $parameters = [], $body = []);
```

### PATCH

```php
$hotmart->patch($endpoint, $parameters = [], $body = []);
```

#### Arguments

| Params       | Type     | Description                                                       |
| ------------ | -------- | ----------------------------------------------------------------- |
| `endpoint`   | `string` | Hotmart API endpoint, example: `/payments/api/v1/subscriptions`   |
| `parameters` | `array`  | Each array index has a query param, example: `status => 'ACTIVE'` |


#### Response

All methods will return array on success or throwing `Exception` errors on failure.
