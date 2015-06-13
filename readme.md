### Morpion fait avec laravel,

#### Main composant
- PHP 5.6.9

### Composant for install
- Node v0.12.4
- Npm 2.11.1
- Bower 1.4.1
- Composer 1.0-dev

Other :

- Laravel Installer 1.2.1

### Start up and install

1. Install composer dependency
  * composer update

2. Install npm dependency
  * npm install

3. Create key 
  * php artisan key:generate
    Response :
    > Application key [<Have to copy the key>] set successfully.
  * copy the key in "config/app.php" exemple :
    > 'key' => env('APP_KEY', 'SomeRandomString'),
    > in  'key' => env('APP_KEY', 'dyUjMddVLXRjkjyjPpBWcY1slofqAQMo'),

4. Install bower dependency
  * bower install 

5. Start up application, in the main directory of morpion-laravel
  * php artisan serv

### Util

1. Init & Refresh BDD
  * php artisan migrate:refresh

