# A PHP Session class with flash (next request only) data

## Installation
```php
require 'session.php';
$session = new Session();
```

## Set new or update existing session variable
```php
$session->set('name', 'value');
$session->set('name', ['value_1','value_2']);
```

## Get session variable value
```php
$value = $session->get('name');
//returns null if 'name' wasn't set
```
If given session variable not found then get returns null.

## Flashing data
Flashing a session means the session variable will be available only for next request. This is particularly useful for showing form validation error.
```php
$session->flash('error', 'Username/Password incorrect');
```

## Retrieving the flash data
Getting the flash data is same as getting any other session variable
```php
$error = $session->get('error');
```
