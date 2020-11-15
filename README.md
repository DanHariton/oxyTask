composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --dump-sql --force
bin/console fos:js-routing:dump --format=json