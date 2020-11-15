#OXY Shop test 

# Requirements
* PHP 7.4 (with SQLite)

# Installation 
* **clone**
* composer install
* php bin/console doctrine:database:create
* php bin/console doctrine:schema:update --dump-sql --force

# Run
* cd public
* php -S 127.0.0.1:8080
* open in browser 127.0.0.1:8080

# Endpoints
* /rest/user PUT (user create)
* /rest/user/{id} GET (get user)
* /rest/user GET (user list)