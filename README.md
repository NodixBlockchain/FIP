demo at http://nodix.eu:81/

install instruction :

git clone https://github.com/NodixBlockchain/FIP

copy 'public, 'app', 'system', 'writable', from CI-App/ to the site location in HTTP server folder

set write permission for 'writable' folder

set baseUrl in app/Config/App.php to the folder's URL

set HTTP server DocumentRoot to the 'public/' folder

to change from production to development environment :

./system/CodeIgniter.php:

define('ENVIRONMENT', $_SERVER['CI_ENVIRONMENT'] ?? 'development');

or

define('ENVIRONMENT', $_SERVER['CI_ENVIRONMENT'] ?? 'production');
