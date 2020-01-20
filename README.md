install instruction :

git clone https://github.com/NodixBlockchain/FIP

copy 'public, 'app', 'system', 'writable', from CI-App/ to the site location in HTTP server folder

set HTTP server DocumentRoot to the 'public/' folder

change write permission to 'writable' folder

set baseUrl in app/Config/App.php to the folder's URL


to change from production to development environment :

./system/CodeIgniter.php:

define('ENVIRONMENT', $_SERVER['CI_ENVIRONMENT'] ?? 'development');
