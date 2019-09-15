# Alf
Additional Laravel Functions

### Installation
Require the z0dd/alf package in your composer.json and update your dependencies:

````composer require z0dd/alf````

You also need to add z0dd\Alf\AlfServiceProvider to your config/app.php providers array:
````php
z0dd\Alf\AlfServiceProvider::class,
````
And in aliases:
````php
'Alf' => z0dd\Alf\Alf::class,
````

Publish config file:

```sh
php artisan vendor:publish --provider="z0dd\Alf\AlfServiceProvider"
````


### License
Released under the MIT License, see [LICENSE](LICENSE).